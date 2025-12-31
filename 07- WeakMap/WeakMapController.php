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
// Weakmap Uses: Caching, Memorization, Prevent Memory Leaks

// PHP Attributes
// Attributes offer the ability to add structured, machine readable metadata information on declarations in code. 
// Classes, methods, functions, parameters, properties and class constants can be the target of an attribute.
// PHP Attributes (introduced in PHP 8) are structured metadata that you can attach to: methods, properties, parameters, functions
// They look like annotations but are native, parsed by PHP itself, not comments.
// Attributes allow you to describe behavior without code logic, making your code cleaner and more declarative.
// Before PHP 8, developers used DocBlock annotations, But these were just comments. PHP could not read them natively. Frameworks needed heavy parsing libraries like Doctrine Annotation Reader.
// Use Cases: Routing definitions, Validation rules, ORM mapping (database entity definitions), Authorization & middleware, Dependency Injection configuration, Serialization control, DTO mapping, Event listeners, Command definitions.
// Think of them as structured comments that your application can read and act upon at runtime. 
// Make validations reusable, structured, and clean.
class CreateUserDTO
{
    #[Email]
    #[NotBlank]
    public string $email;

    #[Length(min: 8)]
    public string $password;
}

// Describe database structure directly on the class.
#[Entity]
#[Table(name: 'users')]
class User
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    public int $id;

    #[Column(type: 'string', length: 255)]
    public string $name;
}

// Middleware / Authorization Mapping
#[RequiresRole('admin')]
function deleteUser() {
   // ...
}

// CLI Command Definition
#[Command(name: 'cache:clear')]
class ClearCacheCommand
{
    // ...
}

// Event Listener Attributes
#[AsEventListener(event: UserRegistered::class)]
class SendWelcomeEmail {}

// Dependency Injection Configuration
#[Inject(Logger::class)]
// public $logger;


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

// Using Attribute in Laravel:
// Laravel's core framework currently does not provide native PHP attribute support for routing and middleware. However, PHP attributes can still be effectively used in Laravel through custom implementations and third-party packages.
// composer require spatie/laravel-route-attributes
// Every attribute must be backed by a class. Write above the class: #[Attribute]
// You can control where attributes can be applied using target flags: #[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
// TARGET_CLASS, TARGET_FUNCTION, TARGET_METHOD, TARGET_PROPERTY, TARGET_CLASS_CONSTANT, TARGET_PARAMETER, TARGET_ALL (default)
// To access attributes at runtime, you use PHP's Reflection API.
