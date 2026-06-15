<?php
// app/Core/helpers.php
function e(string $value): string {
    $clean = $value;
    if (function_exists('iconv')) {
        $converted = @iconv('UTF-8', 'UTF-8//IGNORE', $value);
        if ($converted !== false) {
            $clean = $converted;
        }
    }
    return htmlspecialchars($clean, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $path): void {
    if (preg_match('/^https?:\/\//', $path)) {
        header('Location: ' . $path);
        exit;
    }
    if (str_starts_with($path, '/')) {
        $path = url($path);
    }
    header('Location: ' . $path);
    exit;
}

function appBasePath(): string {
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $basePath = rtrim(str_replace('/index.php', '', $scriptName), '/');
    return ($basePath === '/' || $basePath === '.') ? '' : $basePath;
}

function isLocalHost(string $host): bool {
    $host = strtolower(trim($host));
    if (str_contains($host, ':')) {
        $host = explode(':', $host)[0];
    }
    if ($host === 'localhost' || $host === '127.0.0.1' || $host === '::1') {
        return true;
    }
    return str_ends_with($host, '.test') || str_ends_with($host, '.local');
}

function url(string $path): string {
    $path = '/' . ltrim($path, '/');
    $relative = appBasePath() . $path;

    $base = Env::get('APP_URL', '');
    if ($base === '') {
        return $relative;
    }

    // In local environments, avoid jumping to a different host due to APP_URL mismatch.
    if (preg_match('/^https?:\/\//i', $base)) {
        $baseHost = parse_url($base, PHP_URL_HOST) ?: '';
        $currentHost = $_SERVER['HTTP_HOST'] ?? '';
        if ($currentHost !== '' && $baseHost !== '' && strtolower($baseHost) !== strtolower($currentHost) && isLocalHost($currentHost)) {
            return $relative;
        }
    }

    return rtrim($base, '/') . $path;
}

function asset(string $path): string {
    $path = '/' . ltrim($path, '/');
    $base = Env::get('APP_URL', '');

    $basePath = '';
    if (preg_match('/^https?:\/\//i', $base)) {
        $basePath = (string)(parse_url($base, PHP_URL_PATH) ?? '');
    }

    $docRoot = rtrim((string)($_SERVER['DOCUMENT_ROOT'] ?? ''), '/\\');
    
    // Strip query string and fragment for file existence checks
    $cleanPath = parse_url($path, PHP_URL_PATH) ?? '';
    
    // Check if the file exists directly under the document root
    $rootFile = $docRoot !== '' ? $docRoot . str_replace('/', DIRECTORY_SEPARATOR, $cleanPath) : '';
    
    // Check if the file exists inside public/ relative to the project root
    $projectRoot = dirname(__DIR__, 2);
    $projectPublicFile = $projectRoot . DIRECTORY_SEPARATOR . 'public' . str_replace('/', DIRECTORY_SEPARATOR, $cleanPath);

    $needsPublicPrefix = false;
    if ($docRoot !== '' && !str_starts_with($path, '/public/') && !str_contains($basePath, '/public')) {
        if (!file_exists($rootFile) && file_exists($projectPublicFile)) {
            $needsPublicPrefix = true;
        }
    }

    if ($needsPublicPrefix) {
        $path = '/public' . $path;
    }

    return url($path);
}

function parseDate(?string $dateStr): ?string {
    if (!$dateStr || trim($dateStr) === '') {
        return null;
    }
    $dateStr = trim($dateStr);
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateStr)) {
        return $dateStr;
    }
    if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', $dateStr, $matches)) {
        $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
        $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
        $year = $matches[3];
        return "$year-$month-$day";
    }
    $timestamp = strtotime($dateStr);
    if ($timestamp !== false) {
        return date('Y-m-d', $timestamp);
    }
    return null;
}
