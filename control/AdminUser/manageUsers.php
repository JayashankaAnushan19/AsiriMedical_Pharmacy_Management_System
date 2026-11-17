<?php
require_once __DIR__ . '/../../model/auth.php';
require_staff();

function back_to_users(string $alert = ''): void
{
    if ($alert !== '') {
        echo '<script>alert(' . json_encode($alert) . ')</script>';
    }
    echo '<html><head><meta http-equiv="Refresh" content="0;url=../../view/AdminUser/AdminUser.php"><title>Loading ...</title></head><body></body></html>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    back_to_users();
}
if (!csrf_valid()) {
    back_to_users('Your session expired. Please try again.');
}

$isSuperAdmin = current_role() === ROLE_SUPER_ADMIN;

$id       = (int) ($_POST['txtUserID'] ?? 0);
$nic      = trim((string) ($_POST['txtNICNumber'] ?? ''));
$name     = trim((string) ($_POST['txtUserName'] ?? ''));
$tel      = trim((string) ($_POST['txtUserTel'] ?? ''));
$address  = trim((string) ($_POST['txtUserAddress'] ?? ''));
$role     = (int) ($_POST['txtUserRole'] ?? -1);
$username = trim((string) ($_POST['txtUserUName'] ?? ''));
$password = (string) ($_POST['txtPassword'] ?? '');

/** Only a Super Admin may create, edit or delete Super Admin accounts. */
function guard_target(int $targetId, bool $isSuperAdmin): void
{
    if ($isSuperAdmin || $targetId === 0) {
        return;
    }
    $row = db_row("SELECT `user_Role` FROM `tb_adminuser` WHERE `user_ID` = ?", [$targetId]);
    if ($row && (int) $row['user_Role'] === ROLE_SUPER_ADMIN) {
        back_to_users('Only a Super Admin can change this account.');
    }
}

if (isset($_POST['btn_AddUser']) || isset($_POST['btn_UpdateUser'])) {
    if ($name === '' || $username === '' || !in_array($role, [0, 1, 2, 3], true)) {
        back_to_users('Please fill all fields and select a user role.');
    }
    if ($role === ROLE_SUPER_ADMIN && !$isSuperAdmin) {
        back_to_users('Only a Super Admin can assign the Super Admin role.');
    }
    $taken = db_row(
        "SELECT `user_ID` FROM `tb_adminuser` WHERE `user_Uname` = ? AND `user_Active` = '1' AND `user_ID` <> ?",
        [$username, $id]
    );
    if ($taken) {
        back_to_users('That username is already used by another account.');
    }
}

if (isset($_POST['btn_AddUser'])) {
    if (strlen($password) < 6) {
        back_to_users('Password must be at least 6 characters.');
    }
    db_exec(
        "INSERT INTO `tb_adminuser` (`user_NIC`, `user_Name`, `user_Tel`, `user_Address`, `user_Role`, `user_Uname`, `user_Password`, `user_Active`)
         VALUES (?, ?, ?, ?, ?, ?, ?, '1')",
        [$nic, $name, $tel, $address, (string) $role, $username, hash_password($password)],
        'New User Added Successfully !!!'
    );
} elseif (isset($_POST['btn_UpdateUser'])) {
    guard_target($id, $isSuperAdmin);
    if ($password !== '' && strlen($password) < 6) {
        back_to_users('Password must be at least 6 characters.');
    }
    if ($password !== '') {
        db_exec(
            "UPDATE `tb_adminuser` SET `user_NIC` = ?, `user_Name` = ?, `user_Tel` = ?, `user_Address` = ?, `user_Role` = ?, `user_Uname` = ?, `user_Password` = ? WHERE `user_ID` = ?",
            [$nic, $name, $tel, $address, (string) $role, $username, hash_password($password), $id],
            'User Updated Successfully !!!'
        );
    } else {
        db_exec(
            "UPDATE `tb_adminuser` SET `user_NIC` = ?, `user_Name` = ?, `user_Tel` = ?, `user_Address` = ?, `user_Role` = ?, `user_Uname` = ? WHERE `user_ID` = ?",
            [$nic, $name, $tel, $address, (string) $role, $username, $id],
            'User Updated Successfully !!!'
        );
    }
} elseif (isset($_POST['btn_DeleteUser'])) {
    guard_target($id, $isSuperAdmin);
    if ($id === (int) $_SESSION['UserId']) {
        back_to_users('You cannot delete your own account.');
    }
    db_exec("UPDATE `tb_adminuser` SET `user_Active` = '0' WHERE `user_ID` = ?", [$id], 'User Deleted Successfully !!!');
}

back_to_users();
