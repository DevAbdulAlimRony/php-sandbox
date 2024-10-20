<?php
namespace App\Abstract;

class Text extends Field{
    public function render(): string{
        return <<<HTML
        <input type="text" name="{$this->name}" />
        HTML;
    } 
    // The render method must be implemented, because in abstract class it is defined as abstract
    // or, if we dont implement abstract render method, this class itself should be abstract
    // Though in definition, we have no parameter, but we can use parameter here with default value. Without default value, it will not work

    // Abstract VS Interface:
    // Main Difference: An abstract class can have both abstract and concrete methods and allows single inheritance, while an interface defines a contract with only method signatures and supports multiple inheritance. 
    //When to Use: Use an abstract class for shared code among related classes, and use an interface to define a contract that can be implemented by any class.
}