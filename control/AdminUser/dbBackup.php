<?php
/**
 * Download a full SQL backup of the database.
 * Streams straight to the browser – nothing is written inside the web root.
 */
require_once __DIR__ . '/../../model/auth.php';
require_staff();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['DoBackup']) || !csrf_valid()) {
    header('Location: ../../view/AdminUser/settings.php');
    exit;
}

@set_time_limit(300);
$conn = db();
$dbName = env('DB_NAME', 'db_pms');
$filename = $dbName . '_backup_' . date('Y-m-d_His') . '.sql';

while (ob_get_level() > 0) {
    ob_end_clean();
}
header('Content-Type: application/sql; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: no-store');

echo "-- Asiri Medical PMS backup\n-- Database: `$dbName`\n-- Created: " . date('Y-m-d H:i:s') . "\n\n";
echo "SET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS = 0;\n\n";

$tables = $conn->query('SHOW TABLES');
while ([$table] = $tables->fetch_row()) {
    $create = $conn->query("SHOW CREATE TABLE `$table`")->fetch_row()[1];
    echo "DROP TABLE IF EXISTS `$table`;\n$create;\n\n";

    $rows = $conn->query("SELECT * FROM `$table`", MYSQLI_USE_RESULT);
    while ($row = $rows->fetch_row()) {
        $values = array_map(function ($v) use ($conn) {
            return $v === null ? 'NULL' : "'" . $conn->real_escape_string($v) . "'";
        }, $row);
        echo "INSERT INTO `$table` VALUES (" . implode(',', $values) . ");\n";
    }
    $rows->free();
    echo "\n";
}

echo "SET FOREIGN_KEY_CHECKS = 1;\n";
exit;
