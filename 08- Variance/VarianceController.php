<?php
// Variance ensures type safety.
// If You inherit from a class, now when you override any method from that class, the type hint and return type must be compatible in some programming language and before php 7.4- thats called Invariance
// After 7.4 version, PHP alows overriding methods to return a more specific type. This is Called Return Type Covariance.
// PHP allows to accept less specific parameter types. This is called Parameter Type Contravariance.
// Reverse of them like return type contravariance or parameter type coveriance are not supported. Can do exactly same return type compatible between them.
// Class Constructors dont follow these rules. 
// When using union types in base class, it is covariant when you remove a type while overriding method in the child class.
// For intersection type, it is covariant when you add a type. Opposite for contravariance.

// Liskob Substitution principle: An object and a sub-object or a class and a sub-class must be interchangeable without breaking the code.
// PHP's those rules dont break this solid solid principle.

abstract class Animal{
    protected string $name;

    public function __construct(string $name){
        $this->name = $name;
    }

    abstract public function speak();

    public function eat(Food $food){
        // We used less specific Food Type rather than more specific AnimalFood
        echo $this->name . " eats " . get_class($food);
    }
}

class Cat extends Animal{
    public function speak(){
        echo $this->name . " mews";
    }
} 

interface AnimalShelter{
    public function adopt(string $name): Animal;
}

class CatShelter implements Animalshelter{
    public function adopt(string $name): Cat{
        return new Cat($name);
    }
    // Here parent's Return type is Animal, In child We used more specific return type Cat
}

class Food{}

class AnimalFood extends Food{

}