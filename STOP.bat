@echo off
rem Stops the MySQL server started by RUN.bat (or by XAMPP).
"C:\xampp\mysql\bin\mysqladmin.exe" -uroot shutdown && echo MySQL stopped. || echo MySQL was not running.
timeout /t 3 >nul
