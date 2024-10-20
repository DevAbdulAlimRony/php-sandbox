<?php
    // Traits: Common Functionality for Multiple Classes. If we import trais by 'use traitName', it will import trait in compile time
    // We cant use object of trait, just can use trait in another trait or in class
    // Trait simply copy the codes and paste it into the defined 
    // We can define same method where we are using
    // If same method name pesent in parent class and trait , then method of trait will be called
    // Conflic Resolution: If two traits have same methods (Ex. makeLatte) and we use it in class, it will throw error. But have solution:
    // use CappuccinoTrait, use LatteTrait { LatteTrait::makeLatte instadeof CappuccinoTrait }
    // or, using alias: use LatteTrait { LatteTrait::makeLatte as copyMakeLatte }
    // private method of trait can also be used where imported, but not from outside class. But We can change visibility:
    // use LatteTrait { LatteTrait::makeLatte as public; }
    // We can define properties in trait (visibility and type cant be override, same name with same value cant be redefined in class)
    // We can make abstract method in trait also
    // Static Properties and Methods in Trait
    // Trait should not be used except simple code