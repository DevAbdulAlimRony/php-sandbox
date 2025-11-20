<?php
// Run PHP script in different versions here: https://3v4l.org/

//* New Things in PHP 8.1 *//
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
// Usage of static variables of Inheriheted method.

// Fibers: Think of Fibers as “functions that can be paused and resumed later”, similar to generators but more flexible.
// Fibers are primitives for pausing (suspending) and resuming PHP execution at specific points, without killing the stack or thread.
$fiber = new Fiber(function () {
    Fiber::suspend("Waiting 2 seconds...");
    echo "I’m back!\n";
});

echo $fiber->start(); // Pauses here
sleep(2);
$fiber->resume();
// Fiber can suspend anywhere, generator cant. Fiber can be nested also.

//* New Things in PHP 8.2
// Readable Classes:
readonly class User {
    public function __construct(
        public string $name,
        public int $age
    ) {}
}
$user = new User("Mahbub", 30);
// $user->name = "Rahim"; // ❌ Error (cannot modify)

// DNF Types- Disjunctive Normal Form Types: Allows complex “OR” + “AND” types.
function process((A&B)|null $input) {}

// Standalone Types: null, false, true
function test(): false {
    return false;
}
function getSomething(): null {
    return null;
}

// Sensitive Parameter Redaction
function login(
    #[\SensitiveParameter] $password
): never {
    throw new Exception("Error!");
}

login("secret123");
// Stack trace will show: login('[SensitiveParameter]'), So your password won’t leak.

// New Random Extension
use Random\Randomizer;

$rnd = new Randomizer();

echo $rnd->getInt(1, 10);
echo $rnd->getBytes(8);

//* PHP 8.3
// Typed Class Constants:
class Status {
    public const string ACTIVE = "active";
    public const int CODE = 200;
}

// Granular DateTime Exceptions:
try {
    new DateTime("invalid-date");
} catch (DateMalformedStringException $e) {
    echo "Date string is invalid!";
}

// INI / ENV variables: fallback values
$timeout = ini_get("app.timeout");

// Functions: json_validate('{"name":"Mahbub"}');- true

//* PHP 8.4
// Property Hooks: Let you define custom code on property set or get.
class User2 {
    public string $name {
        set {
            $this->name = strtoupper($value);
        }
    }
}

$u = new User2;
$u->name = "mahbub";

echo $u->name; // "MAHBUB"

// Asymmetric Visibility: Visibility for reading vs writing can be different.
class Account {
    public int $balance {
        get { return $this->balance; }
        private set { $this->balance = $value; }
    }
} // Anyone can read $balance, Only class can modify it.

// DOM Extension HTML5 Support
// $dom = new DOM\HTMLDocument('<!DOCTYPE html><p>Hello!</p>');
// echo $dom->saveHTML();

// New Array Functions: 
// array_find_key(): Find first key that matches a condition.
// array_all(): Check if all elements match.
// array_one: Check if at least one element matches.

// Performance Improvements: Faster function calls, Faster arrays internally, Less memory usage, Better JIT improvements, Improved class loading, Optimized fiber performance, Better handling of large loops. 
// Your code is same, but runs faster
// In PHP 8.4 → runs significantly faster than 8.1/8.2.