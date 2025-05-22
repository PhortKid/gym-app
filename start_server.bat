@echo off
echo Starting PHP-CGI...
start "" "C:\xampp\php\php-cgi.exe" -b 127.0.0.1:9000

timeout /t 2

echo Starting Nginx...
start "" "C:\nginx\nginx.exe"

exit
