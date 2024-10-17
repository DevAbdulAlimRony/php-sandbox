<?php
namespace App;

class DB{
    public static ?DB $instance = null;
    
    private function __construct(public array $config){
        echo 'Instance or Object Created <br/>';
    } // Constructor is private, so we cant create access directly. Need getter

    public static function getInstance(array $config): DB{
        if(slef::$instance === null){
            self::$instance = new DB($config);
        }
        return self::$instance;
    }
    // Now we can create instance by: DB::getInstance();
    // Doesnt matter how many times we call it, It will create just a single instance
    // It is a singleteon pattern, not in a right way, just an example
}