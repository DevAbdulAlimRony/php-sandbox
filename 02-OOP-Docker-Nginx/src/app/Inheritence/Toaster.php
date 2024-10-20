<?php
namespace App\Inheritence;

// If we add final- final class Toaster, It can not be inherited anymore
// When we inherit, we cannot set lower access modifier 
// Like Here size is protected, we cannot set it in ToasterPro as private, but can set as public
class Toaster{
    public array $slices;
    protected int $size;
    
    public function __construct(string $x){
        $this->slices = [];
        $this->size = 2;
    }
    
    public function addSlice(string $slice): void{
        // var_dump($this); In ToasterPro, It will return object refers to ToasterPro class
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

    //* Late Staic Binding: 
    // Early Binding Happens at Compile Time, Late Binding Happens at Runtime
    // Say we have class A and B which inherit A. If we have a method in class A, and we call that method from object of B, it will refer to Object B, not Object of A- This is Late Binding
    // But If we use static and self keyword, Calling from Object of B will refer to Class A that is early Binding, self not following proper inheritence rule here. Solution is Overriding in Child Class (Not Ideal)
    // If we replace self keyword by 'static' keyword, it will late static binding (solved). We can use it in normal function to call static property also
     public static function getClassName() {
        // Using static:: to refer to the called class
        return static::class;
    } // Now, If we call it from ToasterPro, it will refe to ToasterPro Class
}