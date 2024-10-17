<?php
namespace App;

class Text extends Field{
    public function render(): string{
        return <<<HTML
        <input type="text" name="{$this->name}" />
        HTML;
    } // The render method must be implemented, because in abstract class it is defined as abstract
    // or, if we dont implement abstract render method, this class itself should be abstract
    // Though in definition, we have no parameter, but we can use parameter here with default value. Without default value, it will not work
}