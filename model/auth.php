<?php
/**
 * Staff authentication and role-based access.
 *
 * Roles: 0 = Super Admin, 1 = Admin, 2 = Store Keeper, 3 = Cashier
 *
 * Every staff page / handler calls require_staff() (done automatically by
 * control/AdminUser/HeadAndFooter/header.php for pages that use the header).
 */
if (defined('PMS_AUTH_LOADED')) {
    return;
}
define('PMS_AUTH_LOADED', true);

require_once __DIR__ . '/db.php';

const ROLE_SUPER_ADMIN = 0;
const ROLE_ADMIN       = 1;
const ROLE_STOREKEEPER = 2;
const ROLE_CASHIER     = 3;

/** Which roles may open which script (by file name). Not listed = any logged-in staff. */
const PAGE_ROLES = [
    // view/AdminUser
    'home.php'              => [0, 1],
    'lawLevelHome.php'      => [2, 3],
    'pos.php'               => [0, 1, 3],
    'printInvoice.php'      => [0, 1, 3],
    'loadProductPrices.php' => [0, 1, 3],
    'product.php'           => [0, 1],
    'purchase.php'          => [0, 1, 2],
    'stock.php'             => [0, 1, 2],
    'viewStockMoreInfo.php' => [0, 1, 2],
    'supplier.php'          => [0, 1],
    'agent.php'             => [0, 1],
    'sreturn.php'           => [0, 1],
    'preturn.php'           => [0, 1],
    'payment.php'           => [0, 1],
    'AdminUser.php'         => [0, 1],
    'reportSales.php'       => [0, 1],
    'printSales.php'        => [0, 1],
    'printBuySellAll.php'   => [0, 1],
    'settings.php'          => [0, 1],
    // control/AdminUser
    'manageUsers.php'          => [0, 1],
    'manageProduct.php'        => [0, 1],
    'manageCategory.php'       => [0, 1],
    'manageSubCats.php'        => [0, 1],
    'managePrices.php'         => [0, 1, 2],
    'manageCompany.php'        => [0, 1],
    'manageAgents.php'         => [0, 1],
    'loadInvoiceData.php'      => [0, 1],
    'loadSalesRetunData.php'   => [0, 1],
    'saveSalesReturn.php'      => [0, 1],
    'loadPurchaseRetunData.php'=> [0, 1],
    'savePurchaseReturn.php'   => [0, 1],
    'dbBackup.php'             => [0, 1],
];

/** Relative URL from the current script to the project root, e.g. "../../". */
function base_url(): string
{
    $script = realpath($_SERVER['SCRIPT_FILENAME'] ?? '') ?: '';
    $root   = realpath(PMS_ROOT);
    if ($script === '' || strpos($script, $root) !== 0) {
        return '/';
    }
    $rel   = ltrim(str_replace('\\', '/', substr(dirname($script), strlen($root))), '/');
    $depth = $rel === '' ? 0 : substr_count($rel, '/') + 1;
    return str_repeat('../', $depth);
}

function is_logged_in(): bool
{
    return isset($_SESSION['UserId']) && $_SESSION['UserId'] !== '';
}

function current_role(): ?int
{
    return isset($_SESSION['UserLevel']) ? (int) $_SESSION['UserLevel'] : null;
}

function home_for_role(?int $role): string
{
    return in_array($role, [ROLE_STOREKEEPER, ROLE_CASHIER], true) ? 'lawLevelHome.php' : 'home.php';
}

/** Stop the request unless a staff member with an allowed role is logged in. */
function require_staff(?array $roles = null): void
{
    pms_session_start();

    $isAjax = strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest';

    if (!is_logged_in()) {
        if ($isAjax) {
            http_response_code(401);
            exit('Session expired. Please log in again.');
        }
        header('Location: ' . base_url() . 'view/AdminUser/Adminlogin.php');
        exit;
    }

    if ($roles === null) {
        $roles = PAGE_ROLES[basename($_SERVER['SCRIPT_FILENAME'] ?? '')] ?? null;
    }
    if ($roles !== null && !in_array(current_role(), $roles, true)) {
        http_response_code(403);
        if ($isAjax) {
            exit('You do not have permission for this action.');
        }
        $home = base_url() . 'view/AdminUser/' . home_for_role(current_role());
        exit('<!doctype html><meta charset="utf-8"><title>Access denied</title>'
            . '<div style="font-family:sans-serif;text-align:center;margin-top:15vh">'
            . '<h2>Access denied</h2><p>Your account does not have permission to open this page.</p>'
            . '<a href="' . e($home) . '">Back to home</a></div>');
    }
}

/* ---------------- Passwords ---------------- */

function hash_password(string $plain): string
{
    return password_hash($plain, PASSWORD_DEFAULT);
}

function is_password_hash(?string $stored): bool
{
    return $stored !== null && password_get_info($stored)['algo'] !== null;
}

/** Verify a password; also accepts legacy plain-text values (upgraded on login). */
function check_password(string $plain, ?string $stored): bool
{
    if ($stored === null || $stored === '') {
        return false;
    }
    if (is_password_hash($stored)) {
        return password_verify($plain, $stored);
    }
    return hash_equals($stored, $plain);
}

/**
 * Try to log a staff member in. Returns the user row on success, null on failure.
 */
function attempt_staff_login(string $username, string $password): ?array
{
    $user = db_row(
        "SELECT * FROM `tb_adminuser` WHERE `user_Uname` = ? AND `user_Active` = '1' LIMIT 1",
        [$username]
    );
    if (!$user || !check_password($password, $user['user_Password'])) {
        return null;
    }

    // Upgrade legacy plain-text or outdated hashes transparently.
    if (!is_password_hash($user['user_Password']) || password_needs_rehash($user['user_Password'], PASSWORD_DEFAULT)) {
        db_query("UPDATE `tb_adminuser` SET `user_Password` = ? WHERE `user_ID` = ?",
            [hash_password($password), (int) $user['user_ID']]);
    }

    session_regenerate_id(true);
    $_SESSION['UserId']    = $user['user_ID'];
    $_SESSION['UserName']  = $user['user_Name'];
    $_SESSION['UserLevel'] = $user['user_Role'];

    db_query(
        "INSERT INTO `tb_login_history` (`login_History_User_ID`, `login_History_LogDate`, `tb_user_user_ID`) VALUES (?, ?, ?)",
        [(string) $user['user_ID'], date('Y/m/d'), (int) $user['user_ID']]
    );

    return $user;
}

function logout_staff(): void
{
    pms_session_start();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}
