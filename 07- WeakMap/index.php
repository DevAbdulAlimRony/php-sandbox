<?php
// A WeakMap is a special type of map (key-value store) where the keys are objects, and the map does not prevent those objects from being garbage-collected.
// This helps avoid memory leaks in long-running processes.
// WeakMap requires PHP 8+.

$invoice1 = new Invoice();
$invoice2 = $invoice1;
unset($invoice1);

// What is happening here: 
// Invoice1 and Invoice 2 variables are created and names are created in symbol table with a id, and that id references to its values
// Now, we copied invoice1 to invoice2, so there will be two id. If we unset variable1, it will not unset, because variable2 have already the reference. So, extra memory remain.
// PHP 7.1 introduced WeakReferences and 8.1 introduced Weakmap class to solve this problem.
// It can be used for caching type thing.
// In laravel, WeakMap not necessary actually, not so important.

// Using Weakmap:
$invoice3 = new Invoice();
$map = new WeakMap();
$map[$invoice3] = ['a' => 1, 'b' => 2];
var_dump(count($map)); // Output: 2
unset($invoice3);
var_dump($map); // Output: 1
// Weakma Uses: Caching, Memorization, Prevent Memory Leaks


//* New Things in PHP 8.1: *//
// Run PHP script in different versions here: https://3v4l.org/
// Array Unpacking by string key
// Enumerations or Native Support of Enum
// Read Only Properties: We need getters for private property. But if we wanna remove this getters and make it public and still want to make acting like private then,
// public function __constrcut(public readonly string $street);
//Now we can access the property from different class, but cant change state of the property for that readonly keyword. T
// Readonly property must define type, if not type like string int defined, it will throw error.
// We cannot set default value for the readonly property
// Pure Intersection type: private Syncable&Payable $entity (Previous, we could use just or like Payable|PayInterface). 
// Cannot do & | at a time. Only class type is supported for intersection type not int string type thing, because one thing cant be int and string at a time.
// Never Retun Type: Any function that never return a value, maybe just throw a exception or exit the code. public function foo(): never {echo 1; exit;}
// Void vs Never: Calling by never expect to exit the execution.
// Array_is_list: An array is a list when keys are ordered sequentially. Like this- [1,2,3], not this- [1 = 1, 2 => 2] here fist key is 1 , not 0. To check if an array is  a list, we can use that method.
// First Class callable Syntax: $closure = sum(...) - Return a Callable Object. Research why need?
// New keyword using in initialization: public function __construct(public Address $address = new Address())
// Final Constants: final public const STATUS = 'PAID'. Now, if we inherit from this, we cant change this constant in that child.
// Support of Fibers
// Usage of static variables of Inheriheted method