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

// PHP Attributes
// Attributes offer the ability to add structured, machine readable metadat information on declarations in code. 
// Classes, methods, functions, parameters, properties and class constants can be the target of an attribute.

// Example of Symphony Annotation
class InvoiceController{
    /**
     * @Route("/invoices", name="invoice_list")
     */
    public function index(){}
}

// Same Code with Attribute in Symphony
class InvoiceController2{
    // #[Route('/invoices', name: 'invoice_list')]
    // Start with #, I added // at first so that no error show because We have no Route configured now.
    public function index(){}
}
// Its not just an annotation, it can be used to automatically call....
// Ex- Simple Router with Attributes, Research about more example in laravel.