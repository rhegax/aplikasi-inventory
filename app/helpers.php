<?php

function db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $pdo = require BASE_PATH . '/config/database.php';
    }

    return $pdo;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

function redirect(string $path): void
{
    header('Location: ' . url($path));
    exit;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function csrf_check(): void
{
    $token = $_POST['csrf_token'] ?? '';

    if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
        http_response_code(419);
        exit('Token CSRF tidak valid.');
    }
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return null;
    }

    $value = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);

    return $value;
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function require_login(): void
{
    if (!current_user()) {
        redirect('index.php?page=auth');
    }
}

function require_admin(): void
{
    require_login();

    if (current_user()['role'] !== 'admin') {
        http_response_code(403);
        exit('Hanya admin yang diizinkan.');
    }
}

function rupiah(float|int|string|null $value): string
{
    return 'Rp ' . number_format((float) $value, 0, ',', '.');
}

function tanggal_id(?string $datetime): string
{
    if (!$datetime) {
        return '-';
    }

    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
    ];

    $ts = strtotime($datetime);

    if ($ts === false) {
        return '-';
    }

    return date('j', $ts) . ' ' . $bulan[(int) date('n', $ts)] . ' ' . date('Y H:i', $ts);
}
