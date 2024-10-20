<?php
namespace App\Magic;

class Magic{
    private $amount;
    // Magic methods are special methods which override PHP's default action when certain actions are performed on an object
    // __construct(), __destruct(), __call(), __callStatic(), __get(), __set()
    // __isset(), __unset(), __sleep(), __wakeup(), __serialize(), __unseralize()
    // __toString(), __Invoke(), __set_state(), __clone(), __debuginfo()

    // Magic getter and setter:work automatically When property is private or protected. Wont work for public.
    public function __get(string $name){
        var_dump($name);
        // property_exists() - checking property
    }
    public function __set(string $name, $value): void{
        var_dump($name, $value);
    }
    public function __isset(string $name): bool{
        // Gets Called When You Use Isset or Empty Functions on Undefined, Empty Properties
        return array_key_exists($name, $this->data);
    }
    public function __unset(string $name): void{
        // Get Called When You use unset function on undefined or empty properties
    }
    public function __call(string $name, array $arguments){
        // It triggers when We call a undefined or unaccessible like protected method. Rather than showing error, this magic method will be called
        var_dump($name, $arguments);
        if(method_exists($this, $name)){
            call_user_func_array([$this, $name], $arguments);
        } // if method exists call that with arguments
    } // For static method- __callStatic()
    public function __toString(): string{
        return 'string';
        // When we print object directly (echo $object), hooked into it
        // $object instanceof Stringable - return true
        // When we use this magic method, we can add at class- implements Stringable (not requied, recommended)
    }
    public function __invoke(){
        // Gets triggeres when We try to call object Directly- $object()
        // Single Responsibility Classes can be defined Using it. Simple make Class invokable, and call directly $object()
    }
    public function __debugInfo(): ?array{
        // What should be printed when var_dump is used, like If we print password in var_dump, show hash
        return [
            'amount' => '**' . substr($this->amount, -3)
        ];
    }

    // A destructor is called when the object is destructed or the script is stopped or exited.
    //  If you create a __destruct() function, PHP will automatically call this function at the end of the script. 
    public function __destruct(){
         echo "Destructor Calling";
         // It is used for clean up, database connection etc. Not Much Used
         // Ex: Closing Database Connection When Long Script
    }
}