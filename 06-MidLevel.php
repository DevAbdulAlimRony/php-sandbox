<?php
/*== 1. Include Files: When we split Files and Want to Import it into Another ==*/
include 'file.php'; // If not found, will give warning and execute line
require 'file.php'; // If not found, will give error and stop executing
include_once 'file.php'; // Include file if hasn't been included already.
// Say in file.php- we have just echo "Hey". If we include file.php two times, it will show two times. But if we use include_once many times, show just one time
// require_once
var_dump(include 'file.php'); // If file present, return true. If not false.
ob_start();
include './file.php';
$htmlContent = ob_get_clean();
$htmlContent = str_replace('About', 'About Us', $htmlContent); // Replae Content
echo  $htmlContent; // Now, it will show output of html

/*== 2. Error Handling ==*/
function errorHandler(int $type, string $msg, ?string $file = null, ?int $line = null){
    echo $type . ': ' . $msg .  ' in ' . $file .  'on line ' . $line;
    exit;
}
error_reporting(E_ALL & ~E_WARNING); // report all except warning error
set_error_handler('errorHandler', E_ALL);

/*== 3. File System ==*/
$dir = scandir(__DIR__);
var_dump($dir[2]); // ... 06-MidLevel.php
// check: is_file($dir[2]), is_dir($dir[2])
makdir('foo'); // Folder Created
rmdir('foo'); // Folder Deleted
makdir('foo/bar', recursive: true); // Without recursive: true: If the foo directory does not exist, trying to create bar inside it will result in an error.
// Now if you want remove, first remove bar then foo
if(file_exists('foo.txt')){
    echo filesize('foo.txt'); // If no content- size is 0
    file_put_contents('foo.txt', 'Habijabi...');
    clearstatecache(); // If this not provided, can print cache value
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
// XAMPP- APACHE - Config (or manually from folder- find php.ini)
// ; indicates comments
// All Details: https://www.php.net/manual/en/ini.list.php
ini_set('error_reporting', E_ALL & ~E_WARNING); // Error Reporting will not show
ini_set('display_errors', 0); // Error will not display, in production
ini_set('max_execution_time', 3);
var_dum(ini_get('memory_limit')); // 512M
// If we set memory_limit -1, there will be no limit of memory usage- not recommnded
ini_set('max_execution_time', 3);

/*== 5. Basic Apache Configuration and Virtual Hosts ==*/
// XAMPP - Apache - Config - Apache(httpd.conf)
// # is for comment
// ServerRoot - Root of the Server, Listen 80 (Default Port)
// DocumentRoot: htdocs. It can be different in production
// Virtual Hosts: conf/extra/httpd-vhosts.conf: To Configure Virtual Host (We can run multiple website on single server at a time)
// htaccess file: Distributed Configuration File (Dont Use if dont need to)