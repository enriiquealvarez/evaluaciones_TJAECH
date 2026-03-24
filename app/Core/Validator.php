<?php
// app/Core/Validator.php
class Validator {
    private array $errors = [];

    public function required(string $field, $value, string $message): void {
        if (trim((string)$value) === '') {
            $this->errors[$field] = $message;
        }
    }

    public function email(string $field, $value, string $message): void {
        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $message;
        }
    }

    public function regex(string $field, $value, string $pattern, string $message): void {
        if ($value && !preg_match($pattern, $value)) {
            $this->errors[$field] = $message;
        }
    }

    public function minLen(string $field, $value, int $len, string $message): void {
        if ($value && mb_strlen((string)$value) < $len) {
            $this->errors[$field] = $message;
        }
    }

    public function errors(): array {
        return $this->errors;
    }

    public function hasErrors(): bool {
        return !empty($this->errors);
    }
}


