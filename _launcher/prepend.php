<?php
// Loaded automatically before every page by RUN.bat (auto_prepend_file).
// Makes PHP 8 behave like the PHP 7.2 this project was written for,
// without changing any project file.

// PHP 8.1+ throws exceptions on every failed mysqli call; PHP 7 just returned false.
mysqli_report(MYSQLI_REPORT_OFF);

// The app uses local dates (invoices, login history).
date_default_timezone_set('Asia/Colombo');
