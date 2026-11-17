<?php
/**
 * Database migrations.
 *
 *   CLI:  php model/migrate.php
 *   Web:  /model/migrate.php?token=<MIGRATE_TOKEN>   (only when MIGRATE_TOKEN is set in .env;
 *         for shared hosting without SSH – remove the token again afterwards)
 *
 * Runs every file in model/migrations/ (.sql or .php) once, in name order,
 * and records it in the `tb_migrations` table.
 */
require_once __DIR__ . '/db.php';

$isCli = PHP_SAPI === 'cli';
if (!$isCli) {
    $token = (string) env('MIGRATE_TOKEN', '');
    if ($token === '' || !hash_equals($token, (string) ($_GET['token'] ?? ''))) {
        http_response_code(404);
        exit;
    }
    header('Content-Type: text/plain; charset=utf-8');
}

$conn = db();
$conn->query("CREATE TABLE IF NOT EXISTS `tb_migrations` (
    `migration` VARCHAR(190) NOT NULL PRIMARY KEY,
    `applied_at` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$done = array_column(db_all("SELECT `migration` FROM `tb_migrations`"), 'migration');
$files = array_merge(glob(__DIR__ . '/migrations/*.sql') ?: [], glob(__DIR__ . '/migrations/*.php') ?: []);
sort($files);

$ran = 0;
foreach ($files as $file) {
    $name = basename($file);
    if (in_array($name, $done, true)) {
        continue;
    }
    echo "Applying $name ... ";

    if (substr($name, -4) === '.sql') {
        if (!$conn->multi_query(file_get_contents($file))) {
            echo "FAILED: {$conn->error}\n";
            exit(1);
        }
        do {
            if ($r = $conn->store_result()) { $r->free(); }
        } while ($conn->more_results() && $conn->next_result());
        if ($conn->errno) {
            echo "FAILED: {$conn->error}\n";
            exit(1);
        }
        $note = 'ok';
    } else {
        $note = (string) (require $file);
    }

    db_query("INSERT INTO `tb_migrations` (`migration`, `applied_at`) VALUES (?, NOW())", [$name]);
    echo "$note\n";
    $ran++;
}

echo $ran ? "Done: $ran migration(s) applied.\n" : "Database is up to date.\n";
