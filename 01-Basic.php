<?php
/*== 1. Environment Setup ==*/
// Web Server: Client - Server (Hardware) - Web Server (Apache/Nginx Software)
// Ways to Install: Manual Installationin and Configuration in OS, XAMPP type Server(Preconfigured, Cant Run Multiple Version of PHP or Database, Not For Production), Virtual Machine/Docker (Better Alternative)
// Run PHP Script in Command Line: cd directory -> php index.php

/*== 2. Basic Syntax ==*/
echo 'PHP Print'; // If close php here, no need semicolon
echo 'PHP', '', 'Print'; // Same Output as Above
print 'PHP Print'; // Print has a return value 1, same Output of Echo
echo print "PHP Print"; // Output: PHP Print1 , added 1 at last
// Print could be used in expression like if(print()), echo cant: print echo will not work
echo 'Abdul\'s'; // Escaping Quotes
echo "OK\"Nothing\\\\Tata\'\$"; // Escaping Characters
$path = 'C:\\Program Files\\Test';
$printR = array ('a' => 'apple', 'b' => 'banana', 'c' => array ('x', 'y', 'z')); // To Test
print_r($printR); // Print Array in Human Readable Way
// Not So Much Used: printf()- with format specifier like c programming, sprintf()
printf('Binary Equivalent of %d is %b', 12, 12); //or,
printf('Binary of %1$d %1$b', 12); //%o, %X
$m = 123.3253;
$n = 123;
printf('%04d \n', $n); //0123
printf('%08.2f \n', $m); //012332.53
//Returning from printf
$output = sprintf('%s: %s %s', 'Full Name', $fname, $lname);
echo $output;

/*== 2. Variables ==*/
$var = 'nothing'; // Not Start with Number, No Special Char except _, dont accept $this because it refers object
echo "hello ".$var;
echo "Hello {$var}";
var_dump($var); // Information about one or more variables
$x = 1;
$y = $x;
$x = 3;
echo $y; // Output: 1, because variable is assigned by value
$y = &$x; // Now, variable is assigned by reference- Output: 3, anytime x changes, y will change too.
//Variable Swapping
$fname = 'Abdul';
$lname = 'Alim';
printf('Full Name: %2$s %1$s', $lname, $fname);
echo "\n"; // Line Break
// Variable Variables (Create Variable Dynamically)
$foo = bar;
$$foo = baz; // $$foo actually means $bar

/*== 3. PHP in HTML:
        <h1><?php echo'Hello' ?></h1>
shortcut: <h1><?= 'Hellow' ?></h1>
<?php echo '<h1>' . 'Hello' . '</h1>' ?>
==*/

/*== 4. Comments ==*/
// Single Line Comment
# Alternative Single Line Comment
/*Multi Line Comment*/
/** *Documentation Writting */
// #comment - If comment before php closing tag inline, closing tag will not be commented
// Should Not Nest Multi Line Comment, It will give Error

/*== 4. Constants: Cannot Change after Declaring ==*/
define('PI', 3.14); // using define function- name(same rule as variable), value parameter. Will define at runtime.
echo constant('PI');
echo PI; // Output: 3.14
echo defined('PI'); // Output: 1, checking if any constant defined
const STATUS_PAID = 'paid'; // Define constant using const keyword, will define at compile time.
// So, we cant use const into controlled structure like loop or if-else, but can use define() in controlled structure
// When static data, can use const. When dynamic data, can use define(). Ex-
define('STATUS_' . $x, 4);
echo STATUS_1;
// PHP's predefined Constants: PPHP_VERSION, PHP_DEBUG, PHP_OS, PHP_EOL, PHP_INT_MAX, PHP_BINARY, PHP_DATADIR etc
// Magic Constants: It changes depending where it has been used- __LINE__, __FILE__, __DIR__, __FUNCTION__, __CLASS__,
// __TRAIT__, __METHOD__, __NAMESPACE__

/*== 5. Data Types and Type Casting ==*/
// Scalar Types: bool, int, float, string, has no dedicated 'double' but if we check float using gttype() it will show
// double, because float and double same in php
// Compound Types: array, object, callable, iterable
// Special Types: resource, null. Scalar and Special types are primitive data types
// Checking Type: gettype($var)- Only Data Type, var_dump($var) - Data Type with Value
function sum(int $x, int $y){
$x = 5.5; // Though we type hinted int, but it will converted to float here. But not through error
return $x + $y;
}
sum(2, 3); // But if here we take float when type hinted int, it will take just int part
// declare(strict_types=1); If we write this very first at php script, then other type will throgh error
// But even in strict mode, float expected hinted can take int
$typeCast = (int)'5'; // Type Casting: String Casted to Int

/*== 6. Boolean Data Type ==*/
// Boolean: true or false is predefined constants in php
// Not Case Sensitive- true/TRUE both are valid
// integers 0, -0 = false, floats 0.0, minus 0.0 = false, '' = false, '0' = false, [] = false, null = false
$booleanTest = true;
echo $booleanTest; // Output: 1, if it false then shows nothing (empty string)
// Because when we echo boolean var, it type casted to string automatically. So false dont show 0, it shows empty string
echo is_bool($booleanTest); // check if boolean

/*== 7. Integer Data Type: Positive or Negative Numbers without Decimal Points ==*/
// PHP_INT_MAX (0223372036854775807), PHP_INT_MIN
$testInt = 0x2A; // Output: 42. We can take octal or hex, it will show as decimal
// 05 will output to 5, 055 will output to 45. It is taking as octal
// Prefix for Binary: 0b. 0b110 = 6
$testInt2 = PHP_INT_MAX + 1; // When Maximum limit exceeds, it will auto converted to float
// Casting: (int) or (integer) or +$var
$testInt2 = (int) 5.98; // Output: 5 (rounded auto, point will get removed)
$testInt3 = (int) '5ABC'; // Output: 5
$testInt4 = (int) 'ABC'; // Output: 0. Also null and false will be 0
$testInt4 = 2_000_0; // Output: 20000, PHP auto remove underscore from integer. Use Case: Long Number Readability
$testInt4 = (int) '2_000_0'; // Output: 2, casted from string
is_int($testInt);

/*== 7. Float Data Type: Positive or Negative Numbers with Decimal Points ==*/
$testFloat = 13.5e3; // Output: 13500, floating-point number in scientific notation, equivalent to 13.5 × 10³
$testFloat2 = 13.5e-3; // Output: 0.0135
// Can use Underscore like Integer. PHP_FLOAT_MAX, PHP_FLOAT_MIN
echo NAN; // Output: NAN, when calculation cant be done
echo log(-1); // Output: NAN
echo PHP_FLOAT_MAX * 2; // Output: INF (infinity)
// Check: is_infinite(), is_finite(), is_nan(), is_float
// Casting: (float), (floatval)

/*== 7. Null(constant) Data Type: null or NULL ==*/
// When null casted to string, it will empty string
// Check: is_null or use ===
// If variable not defined, it will throgh error but will get null
// Cast to int: 0, to array: [], boolean: false

/*== 8. Expression and Operators ==*/
#Arithmetic Operator: + - * / % **
$number = '10'; // string
var_dump(+$number); // for having + operator, it will cast to integer
var_dump(fdiv(10, 0)); // Output: 10 % 0- Infinity, if fdiv not used throgh error for 10 / 0
// fmod(10, -3) , Output: 1 (10 % 3). Use when mod of floating number
// fdiv and fmod works on floating point numbers to divide and modulus
#Assignment Operator: = += +- *- /= %= **=
#String Operator: . .=
#Comparisn Operator: loose comparisn, strct comparisn, spaceship operator, conditional/ternary etc
#Error Control Operator (@): Not Recommened to Use
$errorControl = @file('foo.txt'); // As file not present it should throgh error, but it will not
# Increment Decrement Operator (++ , --)
$incr = 5;
echo ++$incr; // Output: 6, pre increment then return
echo $incr++; // Output: 5, because it returns first, then post increment
echo $incr; // Output: 6
# Logical Operactor (&& || ! and or xor)
# Bitwise Operator ( & | ^ ~ etc) : Use Case(Encryption, Role Permission)
# (+ == === !== <> !===) Array Operators
    # Execution Operators
    # Type Operator (instanceof)
    # Nullsafe Operator (??)
    # Ternary Operator
    # Operator Precedence and Associativity

    /*== 9. String Data Type: When in Quote ==*/
    $firstName = 'Abdul';
    $lastName = "$firstName Alim"; // or, ${firstName} for Better Readability
    echo $lastName;
    echo $firstName[0]; // Output: A
    $firstName[-2] = ''; // Converted to: Abul
    // Declaration by Heredoc (treats that it is in double quote). Use Case: like pre tag, consider all white space
    // $stringTest = three less than TEXT Line1 Lin2 TEXT; echo nl2br($stringTest).
    // Declaration by Nowdoc:
    //(treats that it is in single quote): three less than 'TEXT' - same just use sigle quote . Any space will render.