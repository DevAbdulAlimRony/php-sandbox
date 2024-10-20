<?php

class Close{
    private $amount;

    // $object1 = clone $object2 (objects are differnt, but property value set others will be same)
    // If we need any clean up after any object clone, hook into __clone() magic method:
    public function __clone(): void{
       //....
     }

}