<?php
# phpinfo();
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