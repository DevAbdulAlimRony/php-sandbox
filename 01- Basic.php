<?php
/*== 1. Environment Setup ==*/
// Web Server: Client - Server (Hardware) - Web Server (Apache/Nginx Software)
// Ways to Install: Manual Installationin and Configuration in OS, XAMPP type Server(Preconfigured, Cant Run Multiple Version of PHP or Database, Not For Production), Virtual Machine/Docker (Better Alternative)
// Run PHP Script in Command Line: cd directory - php index.php

/*== 2. Basic Syntax ==*/
echo 'PHP Print'; // If close php here, no need semicolon
echo 'PHP', '', 'Print'; // Same Output as Above
print 'PHP Print'; // Print has a return value 1, same Output of Echo
echo print "PHP Print"; // Output: PHP Print1 , added 1 at last
// Print could be used in expression like if(print()), echo cant: print echo will not work
print('PHP Print'); // Same as print
echo 'Abdul\'s'; // Escaping Quotes
echo "Abdul's"; // Escaping Quotes
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
echo "\n";
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
// So, we cant use const in controlled structure like loopor if-else, but can use define() in controlled structure
// When static data, can use const. When dynamic data, can use define(). Ex-
define('STATUS_' . $x, 4);
echo STATUS_1;
// PHP's predefined Constants: PPHP_VERSION, PHP_DEBUG, PHP_OS, PHP_EOL, PHP_INT_MAX, PHP_BINARY, PHP_DATADIR etc
// Magic Constants: It changes depending where it has been used- __LINE__, __FILE__, __DIR__, __FUNCTION__, __CLASS__,
// __TRAIT__, __METHOD__, __NAMESPACE__

/*== 5. Data Types and Type Casting ==*/



//Static data check
if($food == 'z') //bad practice
if('z' == $food) //good practice

//Ternary Operator
$n = 13;
(12 == $n) ? "Twelve" : "A Number";

//Switch Case Behavior
$string = "5something";
switch($string){
case 5: //first letter 5 from 5Something. It will work
//To prevent this behavior: case (string) 5:
echo '5';
}

//Operator Precedence
$x = false || true; // false
$y = false or true; // ($y = false) or true. output: false.

//Condition Control Alternative Structure
if ($n % 2 == 0):
echo 'Even';
echo PHP_EOL; //End of the Line Constant
elseif(true):
//...
else:
echo 'Odd';
endif; //switch...endswitch, while...endwhile

//For Loop Multiple Stepping
for($i = 0, $j = 1; $i > 1; $i--, $j++){
//...
}