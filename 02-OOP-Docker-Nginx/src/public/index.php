<?php
declare(strict_types=1);
use App\Basic\Transaction;
# phpinfo();

# 1. Basic
require_once __DIR__ . '/../app/Basic/Transaction.php';
$transaction = new Transaction(100, 'transaction 1');  // creating object
// Parenthesis is not always required depending constructor, but recommended
// var_dump($transaction->amount); // amount is private, cant access. throw error

$transaction->description = 'Transaction 1';  // Can Change Value of Public Property, Bad Practice
$transaction->addTax(8);
$transaction->applyDiscount(10);
$transaction::STATUS_PAID;
$transacion::class; // Magic Constant, Return Classname with Namespace
$transaction->setStatus(Transaction::STATUS_PAID); // Setter call
$transaction->addTax2(8)->applyDiscount2(10); // Method Chaining When Method Returned Object Itself

// Or, We can use Directly Like That:
$class = 'Transaction'; // class name can be stored in a var to use
$amount = (new $class(200, 'Transaction 2'))
    ->addTax2(8)
    ->applyDiscount2(10);
// But, Chaining Methods Not Always Make Sense, Sometimes We need to return value rather than this

// Object Casting 
$arr = [1, 2, 3];
$obj = (object) $arr; // Index is property with corresponding value
var_dump($obj->{1}); // Accessing Object Casted from Array
var_dump((object) 2); // For Integer, property is 'scalar'
// if null casted, we will get empty object

// PHP stdClass:
// In PHP, the stdClass (standard class) is a generic, empty class that is used when an object is required but no class definition is provided.
$json = '{"a":"1", "b":"2"}';
$ar = json_decode($json, true); // json to array
$std = json_decode($json); // true not provided. Now it is a instance of stdClass, 1 and 2 are properties with corresponding values
var_dump($std->a);

// Creating Own Std Class
$std2 = new stdClass();
$std->a = 1;
$std->b = 2;

# 2. Encapsulation:
// We can also access private property using Reflection API rather than getter setter:
$reflectionProperty = new ReflectionProperty(Transaction::class, 'amount');
$reflectionProperty->setAccessible(true);
$reflectionProperty->setValue($transaction, 125);
var_dump($reflectionProperty->getValue($transaction));
// so, private doesn't mean we can't access it at all.
// We will not do this in real application, just an exmp

// Nested Class Property with NullSafe Operator
// require_once '../Customer.php';
// require_once '../PaymentProfile.php';
// require_once '../PaymentGateWay/Bkash.php';
// echo $transaction->customer?->paymentProfile?->id; 
// Checked if customer present, paymentProfile present. If got null, right side code will be descarded

// *Namespace
var_dump(new App\Basic\Transaction(1, '1'));
// We can also namespace our custom function or const (use function ././)
// PHP will try to load classes from current namespace, so we will get an error. 

// *Aliasing Classes: We can have same class name in a directory. If we import same class again, we will get error. Sln:
// use PaymentGateWay\Ex1\Bkash1;
// use PaymentGateWay\Ex2\Bkash1 as Ex2Bkash;

//Import Different Class from Same Namespace Grouping in Single Line
// use PaymentGateWay\Ex1\{Bkash2, Bkash3};
// Or, use PaymentGateWay\Ex1;
// Aliasing Entire Namespace: use PaymentGateWay\Ex1 AS Something;

//* Abstract Class
$fields = [
    new \App\Abstract\Text('btextField'),
    // new \App\Boolean('booleanField'),
    // new \App\Checkbox('checkboxField'),
    // new \App\Radio('radioField'),
];
foreach($fields as $field){
    echo $field->render() . '</br>';
}

//* Annonymous Classes
$annonymous = new Class(1, 2) {
    public function __construct(public int $x, public int $y){}
}; // we can implements interface, can extends class, same way as regular classes
var_dump(get_class($annonymous));
// We cant type hint annonymous, but if we implements any interface, can use that interface as parameter type hint in any function
// We can create annonymous class in regular class, nesting

//* Object Comparisn
// $obj1 == $obj2 : Two objects must be same class, same properties and values(loose comparisn)
// $obj1 === $obj2 : If same instance of the same class
// $ob2 = $obj1, $obj1 is assigned in $obj2's memory, $obj1 === $obj2 will return true because the point to the same zval container
// In comparisn, we can use also > or <

// Variable Storage:
// When we create variable, php stores variable names in Symbol Table
// Every Var is an entry in Symbol Table, which points to a container or data structure that contains variable content or value
// This container where value stores called zend value or zvalue (c language structure)
// values for int etc directly into container, but the object stores only store object identifier to another complex data structure

//* Serialization: 
echo serialize(true); // Output: b:1
echo unserialize(serialize([1, 2, 3])); // Back as Array
echo serialize($transaction); // App\Transaction\"{amount:15....}", private property will get class name prefix
// When you unserialize an object, it will create a new object
// It can be use for deep copying of object, clone creates shallow copying
// Deep copy method creates a copy where the source and the copied variable reference are entirely different. Changing one, would not affect the other one.

// *Iterator:
// We can iterate over object, but if visibility is not public it will not work, also not much performant
$transactionCollection = new \App\Iterator\TransactionCollection([new Transaction(15, 'T 1'), new Transaction(20, 'T 2')]);
foreach($transactionCollection as $transaction){
    echo $transaction->description . PHP_EOL;
}

// *Type Hinting Iterator:
function needIterator(iterable $transactionCollection){
    foreach($transactionCollection as $item){}
}

// *Exception
// setting global exception
set_exception_handler(function(Throwable $e){
    var_dump($e->getMessage());
});
// try{
//     // ..something with class's object
// }
// catch(\App\CustomException\Customer $e){
//     echo $e->getMessag() . ' ' . $e->getFile() . ':' . $e->getLine();
// }
// catch(\App\Exception\CustomException2 $e){
    
// } // or, using pipe operator multiple type
// finally{
    
// }

//* Destruct Object
unset($transaction); // This will call the destructor
$transaction = null; // It will also call the destructor
exit; // It will also call destructor