<?php
namespace App\Inheritence;

//* ToasterPro inherits all public and protected properties and methods from Toaster
// PHP does not support multiple inhertence, we can do multi level inheritence instead
class ToasterPro extends Toaster{
    public int $size = 4;

    //* By Default, It will not call Parent Constructor
    // You dont have to have a constructor in parent class in order to have a constructor in child class
    // constructor signature must not be compatible with parent constructor
    public function __contruct(string $x, string $y){
        parent::__construct($x); // Calling Parent Constructor, Always put on top unless No Pre Logic
        $this->size = 4; // override
        // If we would call parent constructor after size =4, It will be reset to 2 from parent.
    }

    //* Method Override (When You need other custom logic)
    // Method Signature must be compatible as Parent, If not will get Fatal error
    // It is better to match the parameter name, not required
    public function addSlice(string $slice): void{
        parent::addSlice(4); // We copied same functionality just to show use of parent
    }
    
    public function toastBagel(){
        foreach($this->slices as $i => $slice){
           echo ($i + 1) . ': Toasting ' . $slice . PHP_EOL;
        }
    }

    //* When Inheritence is Bad Idea:
    // If It can break encapsulation
    // When You are inhereting, you are inhereting all the props and methods of parent class, doesn't matter it needs or doesn't need in Child Class
    // Inheritence creates tight coupling between parent and child classes
    // Tight coupling refers to a situation where two or more software components are closely connected and depend on each other to function properly. 
    // Loose coupling, on the other hand, means that the components are less dependent on each other and can operate more independently.
}  