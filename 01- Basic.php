<?php
//To Run This Code using code runner from vs code- ctrl+shift+P

$var = 'nothing';
echo "hello".$var;
echo "Hello {$var}";
var_dump($var);

//Constant
define('PI', 3.14);
echo constant('PI');

//Variable Swapping
$fname = 'Abdul';
$lname = 'Alim';
printf('Full Name: %2$s %1$s', $lname, $fname);
echo "\n";

//Number Equivalent
printf('Binary Equivalent of %d is %b', 12, 12); //or,
printf('Binary of %1$d %1$b', 12); //%o, %X

$m = 123.3253;
$n = 123;
printf('%04d \n', $n); //0123
printf('%08.2f \n', $m); //012332.53

//Returning from printf
$output = sprintf('%s: %s %s', 'Full Name', $fname, $lname);
echo $output;

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

//Function: Reuse and Encapsulation(Hide Logic)
//Recursive Function
function factorial($f){
    if($f <= 1){
        return 1;
    }
    return $f * factorial($f - 1); //Recursion
    //factorial(3): 3*factorial(2), 3*2*factorial(1), 3*2*1 
}
//Function Parameter Type Hinting/Check: function something(int $n). checking: if(gettype($n) == 'integer')
//Optional Parameter or Default Value: $n = 'coffee'
//Fixed Return Type: function some():string
//Accept Unlimited Argument: function sum($x, ...$y)

//Spaceship Operator: $x <=> $y (if x greater return 1, if equal return 0, if smaller return -1)

//Null Coalesce Operator: ??
// $left_val ?? right_val (if left value exists return otherwise return right side value)

//Fibonacci by Recursive
function fibonacci($old, $new, $end){
    static $start; //Call Function many time, but value is always same.
    $start = $start ?? 1; //$start is not set in parameter, so value is 1. each time is 1 because of static.

    if($start>$end){
        return;
    }
    $start++;
    echo $old;
    $_tmp = $old + $new;
    $old = $new;
    $new = $_tmp;
    fibonacci($old, $new, $start, $end);
}

//Variable Scope: global $var, echo $GLOBALS[']

//array(), range(), mt_rand()
//foreach loop for associative array. array_keys(), array_values()
//String to Array: explode(', ', string...). , is delimiter here. or using regular expression- preg_split()
//Array to String: join()
//Array Manipulation: pop(), push(), shift(), unshift()

//Associative Array to String:
    //1. Serialization: serialize($array). deserialize()
    //2. JSON Data: json_encode($array). json_decode()
//Associative Array Data remove: unset()

//Array Cloning:
    //1. Copy by Value(Deep Copy): $newArray = $oldArray.
    //2. Copy by Reference(Shallow Copy): $newArray = &$oldArray. Original Variable will also be changed.

//Array Extracting: array_slice() , array_slice($var, 2, null, true). true is for key preservation.
//array_splice - original array modified
//merging array: array_merge. or, use + sign.
//case sensitive sorting: sort(), asort(), rsort(), arsort(), ksort(), krsort(), usort()- customized sorting, sort($var, SORT_STRING)
//Case Insensitive Sort: sort($var, SORT_STRING | SORT_FLAG_CASE)
//Array Searching: in_array(), array_search (loosely search- not check type), array_search($var, 2, true)-strictly search, key_exists()
//Common Element: array_intersect, array_intersect_assoc
//Uncommon Element: array_diff, array_diff_assoc

//Empty Value or Check Data: isset() [''=> set, null=> not set], empty() [''=>empty, if variable is 0, then it is also empty].
//checking 0 value: if(isset() && (is_numeric() || $var != ''))

//Array Utility Functions(Does not modify original array):
    //1. Manipulate each element of an array: array_walk($array, 'functionName')
    //2. Manipulate and return new array: array_map('functionName', $array)
    //3. Run function on each element and if true then return that element: array_filter($array, 'functionName')
    //4. Take each element and call that function like sum each element of array. Function will have oldValue and newValue parameter: array_reduce()

//Functions for array:
    //1. list($a, $b) = $array. elements are assigned in those variable
    //2. range(12, 20, 2): array from 12 to 20. stepping is 2, incrementing two.


//String
$s1 = '$name'; //output: Treat as string if single quote
$s2 = "$name"; //output: Treat as variable if double quote

//String like <pre>: heredoc, null doc if EOD in ''- no \n or that accepted
$s3 = <<<EOD
line 1 \n 
line 2
EOD;

//ASCII Code: ord(), ASCC to Char: chr()
//strlen(), substr(), strrev(), explode(), implode(), join(), str_split()- string extracting by multiple delimiter, strtok(), preg_split(), strpos() - string searching in string
//str_replace(), str_ireplace()
//trim(), ltrim(), rtrim(), wordwrap()
// sscanf() - string extracting

//nl2br()
$ey = "hi \n bye";
echo nl2br($ey);

//Data Read Write from File

//Session
//Session is a storage system.  a session refers to a mechanism that allows a web server to store and maintain stateful information about a user's interactions with a website or web application across multiple HTTP requests and responses. Sessions are a critical part of web development because they enable the server to recognize and remember individual users, track their activities, and maintain personalized data for each user during their visit to the website.
session_name('myapp');
session_start([
    'cookie_lifetime'=>60
]);
$_SESSION['']= ''; //It is saved now in server side.
session_destroy();

//Data Save on Browser by cookie. Session is saved on server, cookie is saved on browser.
// setcookie(); $_COOKIE[]

//Date Time
echo time(); //unix epoch, unix timestamps- from january 1997 to now.
echo mktime(0,0,0,12,1,2023); //unix time from a specific time
echo microtime(true);
echo date('d/m/y'); //Y=Full Year, F=Month Name
echo date('dS M, Y h:i:s A'); //20th December 07:33:10 PM, if H- 13:
echo date('z'); //what day in a year
date_default_timezone_set("Asia/Dhaka");
//strtotime()

//Closure or Anonymous function (no name)- When a function use rarely, single function, no valid name, to use as a callback function
$gr = function($name){
    //...
};
$gr("Abdul");

//Scoping of anonymous function, using parent function's var
function scope(){
    $value = 1;
    $value2 = '';
    $checkScope = function() use ($value, &$value2){
        echo $value;

        $value = 2; //It will not change, because we take it by value, not by reference.
        $value2 = "changed" //It will be changed, because it passed by reference.
    };
    $checkScope();
}
?>