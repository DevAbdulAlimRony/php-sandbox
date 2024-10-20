<?php
// Namespace: Better organization by grouping classes, same name to be used for more than one class
// Let's say, we have classes with same name in different directory without namespace, it will give error
// We can think namespace as virtual directory spaces for our classes
// namespace Bkash;
// Namespacing followed by directory structure is standard
namespace App\Autoload;

class Bkash{

    // new DateTime(): It will thrw error, because it will try to find DateTime class in this namespace
    // new \DateTime(): Using Back Slash menas, it will find in global namespace, not in local. Now It works, or use 'use' keyword to import namespace
    // Sometimes, PHP's built in function and our function's name can be same:
    // Let's say we have explode() method here, but trying to call pHP's explode() function, then use like that:
    // \explode(), it is better for very negligible positive impact on performance also, PHP now knows exact location
}