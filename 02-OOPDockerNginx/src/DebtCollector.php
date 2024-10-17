<?php
namespace App;

// Interface is like a contract that defines all the necessary actions and methods that an object must have
// Abstract Class Used to provide a common base for subclasses, allowing both concrete and abstract methods (methods with or without implementation). Abstract classes can define default behavior and partially implement common functionality.
// Interface Used to define a contract for classes to implement. All methods declared in an interface must be public and abstract (i.e., they cannot have an implementation). Interfaces specify what methods a class must implement, but they do not provide any functionality.
// interface cannot have properties
// A class can implement multiple interfaces
// Interface cannot constructor, can have public constants(cannot be overriden)
// All methods in interface must be public
// We can extends multiple interface in a interface:
// DebtCollector extends Interface1, Interface2

interface DebtCollector{
    public function __construct(); // It says child implement class must have constructor
    public function collect(float $owedAmount): float;
}