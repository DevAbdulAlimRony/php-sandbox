<?php
namespace App\Interface;

class CollectionAgency implements DebtCollector{
    public function __construct(){
        
    }
    public function collect(float $owedAmount): float{
        $guranteed = $owedAmount * 0.5;
        return mt_rand($guranteed, $owedAmount);
    }
}