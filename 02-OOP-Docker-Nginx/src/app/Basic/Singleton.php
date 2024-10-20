<?php
// Singleton Pattern to Create Object of The Class (Not Standard, Just Example Use of Static)
namespace App\Basic;

class Singleton{
    public static ?Singleton $instance = null;
    
    private function __construct(public array $config){
        echo 'Instance or Object Created <br/>';
    } // Constructor is private, so We cant create access directly. Need getter

    public static function getInstance(array $config): Singleton{
        if(self::$instance === null){
            self::$instance = new Singleton($config);
        }
        return self::$instance;
    }

    // Now we can create instance by: Singleton::getInstance();
    // Doesnt matter how many times we call it, It will create just a single instance
    // It is a singleteon pattern, not in a right way, just an example
}