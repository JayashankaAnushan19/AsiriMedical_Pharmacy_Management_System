<?php
require_once __DIR__ . '/../../model/bootstrap.php';

$_SESSION = [];
session_destroy();
header('Location: ../../index.html');
exit;
