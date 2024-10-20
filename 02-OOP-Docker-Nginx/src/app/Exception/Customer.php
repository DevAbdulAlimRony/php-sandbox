<?php
declare(strict_types = 1);

namespace App\CustomException;

class Customer {
    public $amount = 0;

    // Exception: An Exception is Simply an Object of an Exception Class
    public function customExceptions(){
        if($this->amount <= 0){
            throw new \Exception("Invalid");
            // We can use here: InvalidArgumentException()
            // BadFunctionCallException(), BadMethodCallException(), LengthException(), DomainException(), LogicException()
            // OverflowException(), RangeException(), RuntimeException() etc 

            // We can create our own custom Exception class, just extends Exception

            // Exception will find catch block, if not found it will find in global exception
            // try..catch discussed in index.php
        }
    }
}