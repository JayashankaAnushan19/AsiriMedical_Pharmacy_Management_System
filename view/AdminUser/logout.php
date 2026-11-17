<?php
require_once __DIR__ . '/../../model/auth.php';

logout_staff();
header('Location: Adminlogin.php');
exit;
