<?php
namespace App;

// If we add final- final class Toaster, It cant be inherited anymore
class Toaster{
    public array $slices;
    protected int $size;
    // When we inherit, we cannot set lower access modifier 
    // Like Here size is protected, we cannot set it in ToasterPro as private, but can set as public
    // Same Rule applies to all (methods, const, static)

    public function __construct(string $x){
        $this->slices = [];
        $this->size = 2;
    }
    
    public function addSlice(string $slice): void{
        // var_dump($this); // In ToasterPro, It will return object refers to ToasterPro class
        if(count($this->slices) < $this->size){
            $this->slices[] = $slice;
        }
    }

    public function toast(){
        foreach($this->slices as $i => $slice){
            echo ($i + 1) . ': Toasting ' . $slice . PHP_EOL;
            // PHP_EOL is a new line char const
        }
    } 

    final public function cantOverridden(){
        // This method cannot be overriden in child class anymore
    }
}