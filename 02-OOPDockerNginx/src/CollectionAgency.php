<?php
namespace App;

// multiple interface implement: implements Interface1, Interface2
class CollectionAgency implements DebtCollector{
    public function __construct(){
        
    }
    public function collect(float $owedAmount): float{
        $guranteed = $owedAmount * 0.5;
        return mt_rand($guranteed, $owedAmount);
    }
}