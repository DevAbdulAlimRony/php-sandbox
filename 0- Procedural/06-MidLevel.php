<?php
/*== 1. Include Files: When we split Files and Want to Import it into Another ==*/
include 'file.php'; // If not found, will give warning and execute next line
require 'file.php'; // If not found, will give error and stop executing
include_once 'file.php'; // Include file if hasn't been included already.
// Say in file.php- we have just echo "Hey". If we include file.php two times, it will show 'Hey' two times. But if we use include_once many times, show just one time
// require_once
var_dump(include 'file.php'); // If file present, return true. If not false.

// ob_ functions are part of PHP's output buffering mechanism, where ob stands for output buffer. 
// This allows you to control when and how the output is sent to the browser
// While output buffering is active no output is sent from the script, instead the output is stored in an internal buffer.
ob_start();
include './file.php';
$htmlContent = ob_get_clean(); // Clean (erase) the buffer and turn off buffering — this prevents the HTML from being output directly to the browser.
$htmlContent = str_replace('About', 'About Us', $htmlContent); // Replae Content
echo  $htmlContent; // Now, it will show output of html

// Suppose you are generating an invoice from your website, and you want to:
// Generate the HTML output using PHP (maybe from a Blade or other PHP template)
// Store that HTML as a string (instead of immediately displaying it)
// Send that HTML as the body of an email or convert it to PDF
// This is where output buffering is powerful.
// When to Use Output Buffering: Generating dynamic email bodies, Capturing a view/template for processing (e.g., convert to PDF), Controlling output when headers need to be sent before content, Custom error handling or logging output
// Laravel way: $htmlContent = view('invoice', $data)->render();

/*== 2. Error Handling ==*/
function errorHandler(int $type, string $msg, ?string $file = null, ?int $line = null){
    echo $type . ': ' . $msg .  ' in ' . $file .  'on line ' . $line;
    exit; // to terminate script execution, no further code is executed
}
error_reporting(E_ALL & ~E_WARNING); // which type of error to report. report all except warning error
set_error_handler('errorHandler', E_ALL); // Whenever an error matching E_ALL occurs, call my errorHandler() function instead of PHP's default error handler

/*== 3. File System ==*/
$dir = scandir(__DIR__); // Magic Constant __DIR__ will give The directory of the file
var_dump($dir[2]); // ... 06-MidLevel.php
// check: is_file($dir[2]), is_dir($dir[2])
mkdir('foo'); // Folder Created
rmdir('foo'); // Folder Deleted
mkdir('foo/bar', recursive: true); // Without recursive: true: If the foo directory does not exist, trying to create bar inside it will result in an error.
// Now if you want remove, first remove bar then foo
if(file_exists('foo.txt')){
    echo filesize('foo.txt'); // If no content- size is 0
    file_put_contents('foo.txt', 'Habijabi...');
    clearstatcache(); // If this not provided, can print cache value
    echo filesize('foo.txt'); // Now, little bit size
}

// File Opening and Reading Line By Line
if(! file_exists('foo.txt')){
    echo "File Not Found";
    return;
}
$file = fopen('foo.txt', 'r'); // r means we want to read the file
while(($line = fgets($file)) !== false){
    echo $line . '<br />';
}
fclose($file);
// Rather than checking if file exists, @fopen(), if we use like that then if file not found warning will not show, not recommended
// We can read, write from CSV also
// fgetscsv()
// We can print line also in this process:
$content = file_get_contents('foo.txt', offset: 3, length: 4); // Index 3 to length 4 (optional)
echo $content;
// We can read from external server using CURL
file_put_contents('bar.txt', 'hello'); // If file does not exist, create. Otherwise override
file_put_contents('bar.txt', 'hello', FILE_APPEND); // Not Overide, just add after previous
unlink('bar.txt'); // Delete File
copy('foo.txt', 'bar.txt'); // Copy foo.txt into bar.txt
rename('foo.txt', 'bar.txt'); // File Renaming
// path_info() - filename, extension, location

/*== 4. Working with PHP Configuration File: php.ini ==*/
// The configuration file (php.ini) is read when PHP starts up
// XAMPP- APACHE - Config (or manually from folder- find php.ini)
// ; indicates comments
// All Details: https://www.php.net/manual/en/ini.list.php
ini_set('error_reporting', E_ALL & ~E_WARNING); // all types of errors except warnings will be reported
ini_set('display_errors', 0); // Error will not display, in production
var_dump(ini_get('memory_limit')); // 512M
// If we set memory_limit -1, there will be no limit of memory usage- not recommnded
ini_set('max_execution_time', 3);

/*== 5. Basic Apache Configuration and Virtual Hosts ==*/
// XAMPP - Apache - Config - Apache(httpd.conf)
// # is for comment
// ServerRoot - Root of the Server, Listen 80 (Default Port)
// DocumentRoot: htdocs. It can be different in production
// Virtual Hosts: conf/extra/httpd-vhosts.conf: To Configure Virtual Host (We can run multiple website on single server at a time)
// htaccess file: Distributed Configuration File (Dont Use if dont need to)

/*== 5. HTTP Headers ==*/
// Request: Host:localhost:8000, Accept: text/html, Accept-Language: en-US.., Connection: keep-alive, User-Agent: Mozila etc, finally- link with query string params
// Response: Content-Type, server: nginx.., Date, Expires, Connection, Cache-Control, finally- html document
// Status Code: 100-199: Informational, 200-299: Success (200-OK, 201-Created,204-No Content), 300-399: Redirect (301-Moved Permanantly, 304-Not Modified)
// 400-499: Client Error (401-Unauthorized, 403-Forbidden, 404-Not Found, 405- Method Not Allowed)
// 500-599: Server Error (500-Internal Server Error, 502-Bad Gateway)
// header() must be called before any actual output is sent, either by normal HTML tags, blank lines in a file, or from PHP
// on failure, will get E_WARNING Level Error
//  header(string $header, bool $replace = true, int $response_code = 0): void
header('HTTP/1.1 404 Not Found');
header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); // Recommended Use rathr than previous
http_response_code(404);
// headers_sent(), headers_remove(), headers_list()
header('Location: /'); // Redirecting to another location, exit; to make sure next code not execute after redirect
// The optional replace parameter indicates whether the header should replace a previous similar header, or add a second header of the same type. By default it will replace
header('WWW-Authenticate: NTLM', false);
header('WWW-Authenticate: NTLM', false, 201); // default response_code is 0

// Downloading a file from Route
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="rename.pdf"');
readfile(STORAGE_PATH . '/receipt-6-20-2021.pdf');

// Disable Caching
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

// Setting cookie using header rather than setcookie()
header('Set-Cookie: name=value; Secure; Path=/; SameSite=None; Partitioned;');
// Redirect after 5s
header( "refresh:5;url=wherever.php" );
