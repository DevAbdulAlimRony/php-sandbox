<?php

declare(strict_types = 1);

function getTransactionFiles(string $dirPath): array{
    $file = [];

    foreach(scandir($dirPath) as $file){
        if(is_dir($file)){
            continue; // Exclude Folder Dir, Just Take File
        }
        $files[] = $dirPath . $file;
    }
    return $files;
}

function getTransactions(string $fileName, ?callable $transactionHandler = null): array{
    if(! file_exists($fileName)){
         trigger_error('File ' . $fileName . ' does not exist', E_USER_ERROR);
    }

    $file = fopen($fileName, 'r');
    fgetcsv($file); // Exclude the Header, First Line

    $transactions = [];

    while(($transaction = fgetcsv($file)) !== false){
        if($transactionHandler !== null){
            $transaction = $transactionHandler($transaction);
        } // Here, we will use extractTransaction(). But we can have different row format in another file, so for flexibility, we took this formatting method as callback argument
       $transactions[] = $transaction; 
    }
    return $transactions;
}

function extractTransaction(array $transactionRow): array{
    [$date, $checkNumber, $description, $amount] = $transactionRow;
    $amount = (float) str_replace(['$', ','], '', $amount);
    
    return [
        'date' => $date,
        'checkNumber' => $checkNumber,
        'description' => $description,
        'amount' => $amount,
    ];
}

function calculateTotals(array $transactions): array{
    $totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' => 0];
    foreach($transactions as $transaction){
        $totals['netTotal'] += $transaction['amount'];
        
        if($transaction['amount'] >= 0){
            $totals['totalIncome'] += $transaction['amount'];
        }
        else{
            $totals['totalExpense'] += $transaction['amount'];
        }
    }
    // we can use array_reduce or array_sum but it will get less performance
    return $totals;
}