<?php
namespace App\Abstract;

// Abstract class is like a template or the Base Class that the child or concrete class can be extended from
// Abstract class cannot be instantiate, we cannot create object directly from abstract class
// Can Contain abstract methods that only contains methods signature or the definition without the actual implementation
// It knows What, But Don't Know How
abstract class Field{
    public function __construct(protected string $name){
        
    }

    // abstract method's visibility can be public or protected, not private
    abstract public function render(): string;

    // When Should We Use Abstract Class:
    // When We want to force the child class to implement the methods which have some base functionalities
    // We can have some non-abstract common proprties or methods for all child class
    // If We have a abstract class where have bunch of abstract  methods, we should consider using interface
}