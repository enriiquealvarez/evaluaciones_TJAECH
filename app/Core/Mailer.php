<?php
// app/Core/Mailer.php
class Mailer {
    private string $host;
    private int $port;
    private string $encryption;
    private string $username;
    private string $password;
    private string $fromEmail;
    private string $fromName;
    private bool $logErrors;

    public function __construct() {
        $this->host = (string)Env::get('MAIL_HOST', '');
        $this->port = (int)Env::get('MAIL_PORT', 25);
        $this->encryption = (string)Env::get('MAIL_ENCRYPTION', '');
        $this->username = (string)Env::get('MAIL_USERNAME', '');
        $this->password = (string)Env::get('MAIL_PASSWORD', '');
        $this->fromEmail = (string)Env::get('MAIL_FROM_EMAIL', $this->username);
        $this->fromName = (string)Env::get('MAIL_FROM_NAME', 'Soporte');
        $this->logErrors = Env::get('MAIL_LOG_ERRORS', 'false') === 'true';
    }

    public function send(
        string $toEmail,
        string $toName,
        string $subject,
        string $html,
        string $text = '',
        array $attachments = [],
        array $options = []
    ): bool {
        $host = $this->host;
        if ($host === '') {
            return false;
        }
        $transport = $this->encryption === 'ssl' ? 'ssl://' : '';
        $socket = @fsockopen($transport . $host, $this->port, $errno, $errstr, 15);
        if (!$socket) {
            $this->log("SMTP connect error: {$errno} {$errstr}");
            return false;
        }
        if (!$this->expect($socket, 220)) {
            fclose($socket);
            return false;
        }

        $hostname = $this->sanitizeHeader($_SERVER['SERVER_NAME'] ?? 'localhost');
        $this->sendCmd($socket, "EHLO {$hostname}");
        if (!$this->expect($socket, 250)) {
            fclose($socket);
            return false;
        }

        if ($this->encryption === 'tls') {
            $this->sendCmd($socket, "STARTTLS");
            if (!$this->expect($socket, 220)) {
                fclose($socket);
                return false;
            }
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                $this->log('STARTTLS failed.');
                fclose($socket);
                return false;
            }
            $this->sendCmd($socket, "EHLO {$hostname}");
            if (!$this->expect($socket, 250)) {
                fclose($socket);
                return false;
            }
        }

        if ($this->username !== '') {
            $this->sendCmd($socket, "AUTH LOGIN");
            if (!$this->expect($socket, 334)) {
                fclose($socket);
                return false;
            }
            $this->sendCmd($socket, base64_encode($this->username));
            if (!$this->expect($socket, 334)) {
                fclose($socket);
                return false;
            }
            $this->sendCmd($socket, base64_encode($this->password));
            if (!$this->expect($socket, 235)) {
                fclose($socket);
                return false;
            }
        }

        $fromEmailValue = (string)($options['from_email'] ?? $this->fromEmail);
        $fromNameValue = (string)($options['from_name'] ?? $this->fromName);
        $envelopeFromValue = (string)($options['envelope_from'] ?? $this->fromEmail);
        $replyToEmailValue = (string)($options['reply_to_email'] ?? '');
        $replyToNameValue = (string)($options['reply_to_name'] ?? $fromNameValue);

        $fromEmail = $this->sanitizeHeader($fromEmailValue);
        $envelopeFrom = $this->sanitizeHeader($envelopeFromValue);
        $toEmail = $this->sanitizeHeader($toEmail);
        $this->sendCmd($socket, "MAIL FROM:<{$envelopeFrom}>");
        if (!$this->expect($socket, 250)) {
            fclose($socket);
            return false;
        }
        $this->sendCmd($socket, "RCPT TO:<{$toEmail}>");
        if (!$this->expect($socket, 250)) {
            fclose($socket);
            return false;
        }
        $this->sendCmd($socket, "DATA");
        if (!$this->expect($socket, 354)) {
            fclose($socket);
            return false;
        }

        $boundary = '=_tjaech_' . bin2hex(random_bytes(8));
        $subject = $this->sanitizeHeader($subject);
        $fromName = $this->encodeHeader($fromNameValue);
        $toName = $this->encodeHeader($toName);
        $encodedSubject = $this->encodeHeader($subject);
        $replyToEmail = $this->sanitizeHeader($replyToEmailValue);
        $replyToName = $replyToEmail !== '' ? $this->encodeHeader($replyToNameValue) : '';
        $senderName = $this->encodeHeader($this->fromName);
        $senderEmail = $this->sanitizeHeader($envelopeFrom);

        if ($text === '') {
            $text = strip_tags($html);
        }

        $headers = [];
        $headers[] = "From: {$fromName} <{$fromEmail}>";
        if ($fromEmail !== $senderEmail) {
            $headers[] = "Sender: {$senderName} <{$senderEmail}>";
        }
        if ($replyToEmail !== '') {
            $headers[] = "Reply-To: {$replyToName} <{$replyToEmail}>";
        }
        $headers[] = "To: {$toName} <{$toEmail}>";
        $headers[] = "Subject: {$encodedSubject}";
        $headers[] = "MIME-Version: 1.0";
        $hasAttachments = !empty($attachments);
        if ($hasAttachments) {
            $headers[] = "Content-Type: multipart/mixed; boundary=\"{$boundary}\"";
        } else {
            $headers[] = "Content-Type: multipart/alternative; boundary=\"{$boundary}\"";
        }

        $message = implode("\r\n", $headers) . "\r\n\r\n";
        if ($hasAttachments) {
            $altBoundary = '=_tjaech_alt_' . bin2hex(random_bytes(8));
            $message .= "--{$boundary}\r\n";
            $message .= "Content-Type: multipart/alternative; boundary=\"{$altBoundary}\"\r\n\r\n";
            $message .= $this->buildAlternativeBody($altBoundary, $text, $html);
            $message .= "--{$altBoundary}--\r\n";

            foreach ($attachments as $attachment) {
                $part = $this->buildAttachmentPart($boundary, $attachment);
                if ($part !== '') {
                    $message .= $part;
                }
            }
            $message .= "--{$boundary}--\r\n";
        } else {
            $message .= $this->buildAlternativeBody($boundary, $text, $html);
            $message .= "--{$boundary}--\r\n";
        }
        $message .= ".\r\n";

        fwrite($socket, $message);
        if (!$this->expect($socket, 250)) {
            fclose($socket);
            return false;
        }
        $this->sendCmd($socket, "QUIT");
        fclose($socket);
        return true;
    }

    private function buildAlternativeBody(string $boundary, string $text, string $html): string {
        $message = "--{$boundary}\r\n";
        $message .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $message .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $message .= $text . "\r\n\r\n";
        $message .= "--{$boundary}\r\n";
        $message .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $message .= $html . "\r\n\r\n";
        return $message;
    }

    private function buildAttachmentPart(string $boundary, array $attachment): string {
        $path = (string)($attachment['path'] ?? '');
        if ($path === '' || !is_file($path) || !is_readable($path)) {
            $this->log("Attachment not found: {$path}");
            return '';
        }

        $filename = $this->sanitizeHeader((string)($attachment['filename'] ?? basename($path)));
        $mimeType = $this->sanitizeHeader((string)($attachment['mime'] ?? 'application/octet-stream'));
        $content = file_get_contents($path);
        if ($content === false) {
            $this->log("Attachment unreadable: {$path}");
            return '';
        }

        $encoded = chunk_split(base64_encode($content));

        $message = "--{$boundary}\r\n";
        $message .= "Content-Type: {$mimeType}; name=\"{$filename}\"\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n";
        $message .= "Content-Disposition: attachment; filename=\"{$filename}\"\r\n\r\n";
        $message .= $encoded . "\r\n";

        return $message;
    }

    private function sendCmd($socket, string $command): void {
        fwrite($socket, $command . "\r\n");
    }

    private function expect($socket, int $code): bool {
        $response = '';
        while (!feof($socket)) {
            $line = fgets($socket, 515);
            if ($line === false) {
                break;
            }
            $response .= $line;
            if (isset($line[3]) && $line[3] === ' ') {
                break;
            }
        }
        if (!str_starts_with($response, (string)$code)) {
            $this->log("SMTP error expected {$code}: {$response}");
            return false;
        }
        return true;
    }

    private function encodeHeader(string $value): string {
        $clean = $this->sanitizeHeader($value);
        return '=?UTF-8?B?' . base64_encode($clean) . '?=';
    }

    private function sanitizeHeader(string $value): string {
        return trim(preg_replace("/[\r\n]+/", ' ', $value));
    }

    private function log(string $message): void {
        if ($this->logErrors) {
            error_log($message);
        }
    }
}
