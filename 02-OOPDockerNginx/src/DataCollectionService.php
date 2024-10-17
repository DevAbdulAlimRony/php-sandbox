<?php
namespace App;

use App\DebtCollector;
// Polymorphism: enables you to write code that can work with objects of multiple types, providing flexibility and extensibility in your applications.
class DataCollectionService{
    public function collectDebt(DebtCollector $collector){
        // Here, we are using DebtCollector which is implemented in multiple classes.
        // So, We can use Multiple Class Here which u=implemented DebtCollector Interface
        $owedAmount = mt_rand(100, 100);
        $collectedAmount = $collector->collect($owedAmount);

        echo 'Collected $' . $collectedAmount . 'out of $' . $owedAmount . PHP_EOL;
    }
    // Now, we can call- collectDebt(new \App\CollectionAgency()) or any other class which implement DebtCollecto
}