<?php
/**
 * Router for PHP's built-in server (used by RUN.bat).
 * Applies the same access rules as .htaccess.
 */
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
$path = '/' . ltrim(str_replace('\\', '/', $path), '/');

$blocked =
    preg_match('#(^|/)\.#', $path)                                            // dotfiles: .env, .git, .htaccess
    || (preg_match('#^/(model|_launcher|docker)(/|$)#i', $path) && strcasecmp($path, '/model/migrate.php') !== 0)
    || preg_match('#\.(sql|bak|bac|log|md|rar|zip|ini|sh|bat|yml|yaml|example)$#i', $path)
    || preg_match('#(^|/)(Dockerfile|docker-compose\.yml)$#i', $path)
    || preg_match('#/prd_Images/.*\.(php\d?|phtml|phar|html?|svg)$#i', $path);

if ($blocked) {
    http_response_code(403);
    exit('Forbidden');
}

$file = realpath(__DIR__ . '/..' . $path);
if ($file === false) {
    http_response_code(404);
    exit('Page not found');
}

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');

return false; // let the built-in server serve / execute the file
