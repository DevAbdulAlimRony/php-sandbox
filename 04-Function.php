<?php
function foo(){
  echo "Foo";
  //  it can return any value or nothing at all.
  function bar(){
    echo "Bar";
  }
}
foo();
bar(); // foo() must be called to to call bar()

// Type Hint- Defining Return Type
function foo2(): int{
  return 1;
  // return '1'; It will work also, because we are not using strict type
  // return []; It will throw error, beacuse php cant convert it to integer
  // use : declare(strict_types=1); Then '1' will not work, throw erro
}

function voidFunc(): void{
  // return null; It will throw error
  return; // Output: null
}

// Nullable Types
function foo3(): ?int {
   // null value return will be acceptable also
}

// Type Hinting Multiple Types by Pipe Char
function foo4(): int|float|array {
  // We can return int or float or array now
}

// Accepting Lot of Different Return Types
function foo5(): mixed{
  // we cannot use nullable ? with mixed
  // Any Return Type
}

// Parameters (Parameters can be type hinted also, can set default argument)
function foo6(int $x = 2, int|float $y){
  // Optional Parameter cannot be a function called or object
  // Optional Parameters must be defined at last after all the required parameters
  return $x + $y;
}
echo foo6(2, 3);

// Pass by Value and Reference (Default is Pass by Value)
function foo7(&$x, $y){ // defined by & (refrence)
  if($x % 2 === 0){
    $x /= 2;
  }
  if($y % 2 === 0){
    $y /= 2;
  }
  return $x + $y;
}
$a = 6; $b = 6;
foo7($a, $b);
var_dump($a, $b); // $a will be changed to 3, because it passed by refrenced. But $b is still 6 (passed by value)

// Variadic Functions (When We dont know how many arguments we will need)
function sum(int|float ...$numbers): int|float{
  // Now, $numbers is an array
  // (int $x, float $y, ...numbers) or just ...numbers - that type defining is a=valid also
  return array_sum($numbers); // or can use iterator
}
$a = 2;
$b = 3;
$numbers = [3, 4, 5];
echo sum($a, $b, ...$numbers); // Here How we use array as argument here is called argument unpacking or ellipsis operator

// Named Arguments (Dont need define argument in order now)
function foo8($x, $y){
  return $x + $y;
}
echo foo8(y: 6, x: 7); // so y parameter will get 6, x will get 7

// If we pass associative array, array key will be treated as argument name
$arguments = ['x' => 1, 'y' => 2];
echo foo8(...$arguments);

// Variable Scopes
// Global Scope, Local Function Scope
// Making variable in function global
$x = 5;
function foo9(){
    global $x; // This x will reference to the global x, which we declare above the function, not below 10
    $x = 10;
    echo $x;
}
// Super Global: $GLOBALS[]
// static variable: use keyword static:-
//  variables that retain their value even after the function or method in which they are defined has finished execution. Unlike regular variables, static variables are not destroyed and recreated each time the function is called. 

// Variable Function
$func = 'sum';
echo $func(1, 2, 3); // It will call sum() function

// Check if Function is Callable
if(is_callable($func)){
    echo $func(1, 2, 3);
}
else{
    echo "Function doesn/'t exist";
}

// Anonymous or Lambda Function which has no Name, Store in Variable
$sum2 = function(...$numbers) {
    return array_sum($numbers);
};
echo $sum2(2, 3);

// Accessing Variable from Parent Scope in Annonymous
$useInLambda = 2;
// It will throw error if used in annonymous function, we cant use global in annonymous. Solution: use keyword
$accessFromParent = function() use ($useInLambda) {
    // use (&$useInLambda) - Now, it will passed by reference. If we change here, globally changed
    echo $useInLambda;
};

// Callback Function: Function used as argument in another function
array_map('foo', $numbers); // foo is the function here, we can also store function in variable then can use var here or directly can use annonymous function
$sum3 = function(callable $callback, ...$numbers){
    return $callback(array_sum($numbers));
};
function callableFunc($element){
    return $element * 2;
}
echo $sum('callableFunc', 1, 2, 3); // 1 * 2 + 2 * 2 + 2 * 3

// Arrow Function: Cleaner Syntax for Annonymous Function
$y = 5;
$manipulatedNumbers = array_map(fn($number) => $number * $number + $y, $numbers);
// Advantage: We can use parent scope without using 'use keyword' in arrow function
// We cannot have multi line expression in arrow function