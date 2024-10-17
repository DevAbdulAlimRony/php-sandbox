<?php
# phpinfo();
# All OOP Discussed Here and in Transaction.php
declare(strict_types=1);
require_once '../Transaction.php';
// It should be,
require_once __DIR__ . '/../Transaction.php'; // If we not use it, in command line it will fail

// Creating Object of the Transaction Class
$transaction = new Transaction(100, 'transaction 1'); 
// Parenthesis is not always required depending constructor, but recommended
// var_dump($transaction->amount); // It could throw error, if it were a private property

// We can change public property
$transaction->description = 'Transaction 1'; 
//* Changing Property like that is Bad. 
// We can set it as private and make getter setter if Need, But That Means the same thing as public, right?.
// So geteters and setters don't always break the encapsulation.

// We can also access private property using reflection api:
$reflectionProperty = new ReflectionProperty(Transaction::class, 'amount');
$reflectionProperty->setAccessible(true);
$reflectionProperty->setValue($transaction, 125);
var_dump($reflectionProperty->getValue($transaction));
// so, private doesn't mean we can't access it at all.
// We will not do this in real application, just an exmp

$transaction->addTax(8);
$transaction->applyDiscount(10);
var_dump($transaction->getAmount());

// Accessing public constant
$transaction::STATUS_PAID;
$transacion::class; // Magic Constant, Return Classname with Namespace
$transaction->setStatus(Transaction::STATUS_PAID); // Setter call

// We can use Method Chaining When We returned $this from Method
$transaction->addTax2(8)->applyDiscount2(10);
var_dump($transaction->getAmount());

// Or, We can use Directly Like That:
$class = 'Transaction'; // class name can be stored in a var to use
$amount = (new $class(200, 'Transaction 2'))
          ->addTax2(8)
          ->applyDiscount2(10)
          ->getAmount();
var_dump($amount);
// But, Chaining Methods Not Always Make Sense, Sometimes We need to return value rather than this

// PHP stdClass
// In PHP, the stdClass (standard class) is a generic, empty class that is used when an object is required but no class definition is provided.
$json = '{"a":"1", "b":"2"}';
$ar = json_decode($json, true); // json to array
$std = json_decode($json); // Now it is a instance of stdClass, 1 and 2 are properties with corresponding values
var_dump($std->a);

// Creating Own Std Class
$std2 = new stdClass();
$std->a = 1;
$std->b = 2;

// Object Casting 
$arr = [1, 2, 3];
$obj = (object) $arr; // Index is property with corresponding value
var_dump($obj->{1}); // Accessing Object Casted from Array
var_dump((object) 2); // For Integer, property is 'scalar'
// if null casted, we will get empty object

// Nested Class Property with NullSafe Operator
require_once '../Customer.php';
require_once '../PaymentProfile.php';
require_once '../PaymentGateWay/Bkash.php';
echo $transaction->customer?->paymentProfile?->id; // Checked if customer present, paymentProfile present. If got null, right side code will be descarded

// Namespace: In Bkash Class We used namespace Now, . We can call it like that:
var_dump(new PaymentGateWay\Bkash());
// Or,
use PaymentGateWay\Bkash;
var_dump(new Bkash());
// We can also namespace our custom function or const (use function ././)
// PHP will try to load classes from current namespace, so we will get an error. 

// Abstract Class
$fields = [
    new \App\Text('btextField'),
    // new \App\Boolean('booleanField'),
    // new \App\Checkbox('checkboxField'),
    // new \App\Radio('radioField'),
];
foreach($fields as $field){
    echo $field->render() . '</br>';
}

// Annonymous Classes
$annonymous = new Class(1, 2) {
    public function __construct(public int $x, public int $y){}
}; // we can implements interface, can extends class, same way as regular classes
var_dump(get_class($annonymous));
// We cant type hint annonymous, but if we implements any interface, can use that interface as parameter type hint in any function
// We can create annonymous class in regular class, nesting
// Main Use Case: Testing

// Object Comparisn
// $obj1 == $obj2 : Two objects must be same class, same properties and values(loose comparisn)
// $obj1 === $obj2 : If same instance of the same class
// $ob2 = $obj1, $obj1 is assigned in $obj2's memory, $obj1 === $obj2 will return true because the point to the same zval container
// In comparisn, we can use also > or <

// Variable Storage:
// When we create variable, php stores variable names in Symbol Table
// Every Var is an entry in Symbol Table, which points to a container or data structure that contains variable content or value
// This container where value stores called zend value or zvalue (c language structure)
// values for int etc directly into container, but the object stores only store object identifier to another complex data structure

// Serialization: Convert value from any (except resource, closure, some built in object) to string type
echo serialize(true); // Output: b:1
echo unserialize(serialize([1, 2, 3])); // Back as Array
echo serialize($invoice); // App\Transaction\"{amount:15....}", private property will get clas name prefix
// When you unserialize an object, it will create a new object
// It can be use for deep copying of object, clone creates shallow copying
// Deep copy method creates a copy where the source and the copied variable reference are entirely different. Changing one, would not affect the other one.

// Iterator:
// We can iterate over object, but if visibility is not public it will not work, also not much performant
$transactionCollection = new TransactionCollection([new \App\Transaction(15, 'T 1'), new \App\Transaction(20, 'T 2')]);
foreach($transactionCollection as $transaction){
    echo $transaction->description . PHP_EOL;
}

// Type Hinting Iterator:
function needIterator(iterable $transactionCollection){
    foreach($iterable as $item){}
}

// Exception
try{
    // ..something with class's object
}
catch(\App\Exception\CustomException $e){
    echo $e->getMessag() . ' ' . $e->getFile() . ':' . $e->getLine();
}
catch(\App\Exception\CustomException2 $e){
    
} // or, using pipe operator multiple type
finally{
    
}

// Date Time Object:
$dateTime = new DateTime(); // we ca pass arguments like - tomorrow, tuesday noon, yesterday noon, 05/12/2024 2:03PM
$dateTime->setTimeZone(new DateTimeZone('Europe/Amsterdam'));
echo $dateTime->format('m/d/Y g:i A') . PHP_EOL;
$dateTime->getTimeZone()->getName();
$dateTime->setDate(2021, 4, 21)->setTime(2, 25);

$date = '15/05/2021 3:30PM'; // When use slash ameriacan month day year format, - or . will take day month year format, or:
$dateTime2 = DateTime::createFormat('d/m/Y g:iA', $date); // If time portion not present in both, it will set current time
// If You want midnight time, ->setTime(0, 0)

// Comapare Date Time Object
$dateTime1 < $dateTime2; // so, we can use comparisn operator

// Difference Between Two Date Time
$dateTime1->diff($dateTime2)->format('%Y years, %m months, %d days, %H, %i, %s'); // behind the scene- dateTime2 - dateTime1
// %a : Total Number of Days, %R%a: number of days with positive negative sign
// property: $dateTime1->diff($dateTime2)->days

// Interval Object
$interval = new DateInterval('P3M2D'); // 3 Months 2 Days Interval
$interval->invert = 1; // Positive Time Period, 0 is negative
$dateTime->add($interval); // sub()

// Operation on Date Object will change the Original Object. Ex Sol:
$from = new DateTime();
$to = (clone $from)->add(new DateInterval('P1M')); // Another Solution:

// Immutable Date Time Object
$from2 = new DateTimeImmutable();
$to2 = $from2->add(new DateInterval('P1M'));
// to perform any operation on immutable object, we have to reassign it on avariable:
$to2 = $to2->add(new DateInterval('P1M')); // If not reassigned, it will not add 

// Iterating Over a date Period
$period = new DatePeriod(new DateTime('05/01/2021'), new DateInterval('P1D'), new DateTime('05/31/2021')); // 1.5 to 30.5 in 1 day interval
// new DateTime('05/01/2021'), new DateInterval('P1D'), 3, DatePeriod::EXCLUDE_START_DATE')
foreach($period as $date){
    echo $date->format('d/m/Y'). PHP_EOL;
}

// Carbon Library: More Robust Solution on Date Time Object

// setting global exception
set_exception_handler(function(Throwable $e){
    var_dump($e->getMessage());
});

unset($transaction); // This will call the destructor
$transaction = null; // It will also call the destructor
exit; // It will also call destructor

// Aliasing Classes: We can have same class name in a directory. If we import same class again, we will get error. Sln:
use PaymentGateWay\Ex1\Bkash1;
use PaymentGateWay\Ex2\Bkash1 as Ex2Bkash;
var_dump(new Bkash1(), new Ex2Bkash());

//Import Different Class from Same Namespace Grouping in Single Line
use PaymentGateWay\Ex1\{Bkash2, Bkash3};
// Or,
use PaymentGateWay\Ex1;
var_dum(new Ex1\Bkash2());
var_dum(new Ex1\Bkash3());

// Aliasing Entire Namespace
use PaymentGateWay\Ex1 AS Something;

// Auto Loading: More Class, More line of require or include. Autoloading solve this:
sql_autoload_register(function($class) {
    // We will make full path with case sensitivity
    $path = __DIR__ . '/../' . lcfirst(str_replace('\\', '/',$class)) . '.php';
    if(file_exists($path)){
        require $path;
    }
});
sql_autoload_register(function($class) {
    var_dump($class);
}, prepend: true); // If multiple autoloader, it will run at first
// But we will not use this custom function for auto-loading, We will use 'composer'

// *Composer
// Composer is a Tool for Dependency Management in PHP
// We can install it manually, can install in dockerFile using curl command
// Install Package: composer require vendorExp/packageExp
// composer init : Creates composer.json file, Now you can put your package name manually there also
// composer lock file just contain exact versionof the packages. When we run 'composer install', if lock file present install based on it. If not present, it will work like composer require, lock fill will be created
// The composer.lock file prevents you from automatically getting the latest versions of your dependencies.
// If We run composer update, package will upadate as in composer.json file's version specified
// update will fetch the latest matching versions (according to your composer.json file) and update the lock file with the new versions.
// In vendor directory, all of packages source code exists.
// In JSON: require lists for production, require-dev lists for development
// In vendor, we will get autoload.php file also

// Import Composer AutoLoader to Work
require __DIR__ . '/../vendor/autoload.php';
// But composer dont know how to autoload our own classes. Solution:
// In composer.json, add this:
// "autload": {
//     "psr-4": {
//         "App\\": "app/"
//     }
// }
// Then, regenarate autoload files : composer dump-autoload
// Class will be added in vendor/autoload_psr4.php file
// Now, dont need to write require again and again
// composer dump-autoload -o : Generate Optimized Autoloading , all classes will be indexed in vendor/autload-classmap.php (Use just in Production to make faster)
// We should add vendor in .gitignore file


// PSR (PHP Standard Recommendation): How will We Write Code so that It can be Consistent for Every Developer:
// https://www.php-fig.org/psr/
// Extension can be used with Editor