<?php
/**
 * Application bootstrap: configuration, error handling, timezone, sessions.
 * Loaded once by model/db_connection.php (and model/auth.php).
 */
if (defined('PMS_BOOTSTRAPPED')) {
    return;
}
define('PMS_BOOTSTRAPPED', true);
define('PMS_ROOT', dirname(__DIR__));

/* ---------- .env loader ---------- */
(function () {
    $file = PMS_ROOT . DIRECTORY_SEPARATOR . '.env';
    if (!is_readable($file)) {
        return;
    }
    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) {
            continue;
        }
        [$key, $value] = array_map('trim', explode('=', $line, 2));
        $value = trim($value, "\"'");
        // Real environment variables (Docker, hosting panel) win over .env
        if (getenv($key) === false) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
})();

function env(string $key, $default = null)
{
    $value = getenv($key);
    if ($value === false || $value === '') {
        return $default;
    }
    switch (strtolower($value)) {
        case 'true':  return true;
        case 'false': return false;
    }
    return $value;
}

/* ---------- Errors ---------- */
define('APP_DEBUG', (bool) env('APP_DEBUG', false));
error_reporting(E_ALL);
ini_set('display_errors', APP_DEBUG ? '1' : '0');
ini_set('log_errors', '1');
if (!APP_DEBUG) {
    // Hide notices/warnings from legacy code in production; they still go to the log.
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
}

/* ---------- Locale ---------- */
date_default_timezone_set(env('APP_TIMEZONE', 'Asia/Colombo'));

/* ---------- Database driver behaviour ---------- */
// PHP 8.1+ throws on every failed query; the app checks return values instead.
mysqli_report(MYSQLI_REPORT_OFF);

/* ---------- Sessions ---------- */
function pms_session_start(): void
{
    if (session_status() !== PHP_SESSION_NONE) {
        return;
    }
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $https,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    ini_set('session.use_strict_mode', '1');
    session_start();
}

if (PHP_SAPI !== 'cli' && !headers_sent()) {
    pms_session_start();
}

/* ---------- CSRF ---------- */
function csrf_token(): string
{
    pms_session_start();
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

/** Hidden input to put inside every POST form. */
function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . csrf_token() . '">';
}

function csrf_valid(): bool
{
    $sent = $_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    return is_string($sent) && $sent !== '' && hash_equals(csrf_token(), $sent);
}

/* ---------- Output helpers ---------- */
/** Escape for HTML output. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
