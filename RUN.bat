@echo off
setlocal
title Asiri Medical PMS
cd /d "%~dp0"

rem ===== Settings =====
set "XAMPP=C:\xampp"
set "PORT=8000"
set "DB=db_pms"
rem ====================

set "PHP=%XAMPP%\php\php.exe"
set "MYSQL=%XAMPP%\mysql\bin\mysql.exe"
set "MYSQLADMIN=%XAMPP%\mysql\bin\mysqladmin.exe"
set "MYSQLD=%XAMPP%\mysql\bin\mysqld.exe"

if not exist "%PHP%" (
    echo [ERROR] XAMPP not found at %XAMPP%. Edit XAMPP= at the top of RUN.bat.
    pause & exit /b 1
)

rem ---- 1. MySQL ----
"%MYSQLADMIN%" -uroot --silent ping >nul 2>&1
if errorlevel 1 (
    echo Starting MySQL...
    start "XAMPP MySQL - do not close" /min "%MYSQLD%" --defaults-file="%XAMPP%\mysql\bin\my.ini" --standalone
    for /l %%i in (1,1,30) do (
        "%MYSQLADMIN%" -uroot --silent ping >nul 2>&1 && goto mysql_up
        timeout /t 1 /nobreak >nul
    )
    echo [ERROR] MySQL did not start. Is port 3306 used by another program?
    pause & exit /b 1
)
:mysql_up
echo MySQL is running.

rem ---- 2. Database (imported only the first time) ----
"%MYSQL%" -uroot -e "USE %DB%" >nul 2>&1
if errorlevel 1 (
    echo Creating database %DB% from model\db_pms.sql ...
    "%MYSQL%" -uroot -e "CREATE DATABASE %DB% CHARACTER SET utf8 COLLATE utf8_general_ci"
    "%MYSQL%" -uroot %DB% < "model\db_pms.sql"
    if errorlevel 1 ( echo [ERROR] Import failed. & pause & exit /b 1 )
    echo Database imported.
) else (
    echo Database %DB% already exists - using it.
)

rem ---- 3. Web server (XAMPP's PHP, serving this folder) ----
if not exist "_launcher\logs" mkdir "_launcher\logs"
echo.
echo ============================================================
echo   Open:   http://localhost:%PORT%/
echo   Admin:  http://localhost:%PORT%/view/AdminUser/Adminlogin.php
echo           user: admin   pass: 1234
echo   PHP errors log: _launcher\logs\php_errors.log
echo   Close this window (or Ctrl+C) to stop the website.
echo   Run STOP.bat to also stop MySQL.
echo ============================================================
echo.
start "" "http://localhost:%PORT%/"

"%PHP%" -S localhost:%PORT% -t "%~dp0." ^
  -d "auto_prepend_file=%~dp0_launcher\prepend.php" ^
  -d output_buffering=4096 ^
  -d display_errors=Off ^
  -d log_errors=On ^
  -d "error_log=%~dp0_launcher\logs\php_errors.log" ^
  -d "session.save_path=%XAMPP%\tmp"

pause
