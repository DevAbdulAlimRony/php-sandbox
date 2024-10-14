<?php

declare(strict_types = 1); //  strictly enforce types in function calls

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR; 
// dirname(__DIR__): Parent Directory of the Directory where current file Located (One Level Up from Current Directory)
// DIRECTORY_SEPARATOR: / on Linux/macOS or \ on Windows, platform-independent code

define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR); // Creates Constant APP_PATH - ./app/
define('FILES_PATH', $root . 'transaction_files' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', $root . 'views' . DIRECTORY_SEPARATOR);

require APP_PATH . 'App.php';
require APP_PATH . 'helpers.php';

$files = getTransactionFiles(FILES_PATH);

$transactions = [];
foreach($files as $file){
    $transactions = array_merge($transactions, getTransactions($file, 'extractTransaction'));
}

$totals = calculateTotals($transactions);

require VIEWS_PATH . 'transactions.php';
// Now, $transactions varible will be available within the view file