<?php
// Hash every staff password that is still stored as plain text.
require_once __DIR__ . '/../auth.php';

$count = 0;
foreach (db_all("SELECT `user_ID`, `user_Password` FROM `tb_adminuser`") as $u) {
    if ($u['user_Password'] !== null && $u['user_Password'] !== '' && !is_password_hash($u['user_Password'])) {
        db_query("UPDATE `tb_adminuser` SET `user_Password` = ? WHERE `user_ID` = ?",
            [hash_password($u['user_Password']), (int) $u['user_ID']]);
        $count++;
    }
}
return "hashed $count password(s)";
