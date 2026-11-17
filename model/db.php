<?php
/**
 * Database layer.
 *
 * New code:   db_query($sql, [$param, ...])  -> mysqli_result|bool  (prepared statement)
 *             db_row($sql, [...])            -> array|null
 *             db_all($sql, [...])            -> array
 *             db_exec($sql, [...], $msg)     -> bool (shows $msg alert on success)
 * Legacy:     setConnection(), runQuary(), runSearchQuary() still work.
 */
if (defined('PMS_DB_LOADED')) { // loaded via require_once only
    return;
}
define('PMS_DB_LOADED', true);

require_once __DIR__ . '/bootstrap.php';

/** Open a new connection (legacy API – callers may close it). */
function setConnection()
{
    $conn = new mysqli(
        env('DB_HOST', '127.0.0.1'),
        env('DB_USER', 'root'),
        env('DB_PASS', ''),
        env('DB_NAME', 'db_pms'),
        (int) env('DB_PORT', 3306)
    );

    if ($conn->connect_error) {
        error_log('DB connection failed: ' . $conn->connect_error);
        http_response_code(503);
        die(APP_DEBUG
            ? 'Database connection failed: ' . e($conn->connect_error)
            : 'The system is temporarily unavailable. Please try again shortly.');
    }

    $conn->set_charset('utf8mb4');
    return $conn;
}

/** Shared connection for the request (never close this one). */
function db(): mysqli
{
    static $conn = null;
    if ($conn === null) {
        $conn = setConnection();
    }
    return $conn;
}

/**
 * Run a prepared statement. Use ? placeholders and pass values in $params.
 * Returns mysqli_result for SELECT, true for other statements, false on error.
 */
function db_query(string $sql, array $params = [])
{
    $conn = db();
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        error_log('SQL prepare failed: ' . $conn->error . ' | ' . $sql);
        return false;
    }
    if ($params) {
        $types = '';
        foreach ($params as $i => $p) {
            if (is_int($p))       { $types .= 'i'; }
            elseif (is_float($p)) { $types .= 'd'; }
            else                  { $types .= 's'; $params[$i] = $p === null ? null : (string) $p; }
        }
        $stmt->bind_param($types, ...array_values($params));
    }
    if (!$stmt->execute()) {
        error_log('SQL execute failed: ' . $stmt->error . ' | ' . $sql);
        $stmt->close();
        return false;
    }
    $result = $stmt->get_result();
    $stmt->close();
    return $result === false ? true : $result;
}

function db_row(string $sql, array $params = []): ?array
{
    $res = db_query($sql, $params);
    return ($res instanceof mysqli_result) ? ($res->fetch_assoc() ?: null) : null;
}

function db_all(string $sql, array $params = []): array
{
    $res = db_query($sql, $params);
    return ($res instanceof mysqli_result) ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

function db_insert_id(): int
{
    return (int) db()->insert_id;
}

/** Prepared replacement for runQuary(): runs the statement and alerts $msg on success. */
function db_exec(string $sql, array $params = [], string $msg = ''): bool
{
    $ok = db_query($sql, $params) !== false;
    if ($ok && $msg !== '') {
        echo '<script>alert(' . json_encode($msg) . ')</script>';
    } elseif (!$ok) {
        echo '<script>alert("Something went wrong. Please try again.")</script>';
    }
    return $ok;
}

/* ---------------- Legacy API ---------------- */

function runQuary($myCommand = "", $msg = "")
{
    $Connection = setConnection();
    if (mysqli_query($Connection, $myCommand)) {
        echo '<script>alert(' . json_encode($msg) . ')</script>';
    } else {
        error_log('SQL error: ' . mysqli_error($Connection) . ' | ' . $myCommand);
        echo APP_DEBUG ? 'Error ' . e(mysqli_error($Connection)) : '<script>alert("Something went wrong. Please try again.")</script>';
    }
    mysqli_close($Connection);
}

function runSearchQuary($myCommand = "")
{
    $Connection = setConnection();
    $record = null;
    $res = mysqli_query($Connection, $myCommand);
    if ($res) {
        $record = mysqli_fetch_assoc($res);
    } else {
        error_log('SQL error: ' . mysqli_error($Connection));
    }
    mysqli_close($Connection);
    return print_r($record);
}
