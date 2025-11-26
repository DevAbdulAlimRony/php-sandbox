<?php
/*== 1. Array Declaration and Checking ==*/
$array1 = [1, 2, 3];
$array2 = array(1, 2, 3);
echo $array1[1]; // Output: 2 (at index 1)
echo $array1[-1]; // Output: Undefined Array Key
var_dump(isset($array1[2])); // Output: true. Checking array index defined or not. If value is null, return false
$array1[1] = 5; // 2 will be replaced by 5 called mutating
$array1[] = 10; // Push 10 in the End of the Array
print_r($array1); // Human Readable Output Checking

$array3 = [
'php' => '8.0',
'python' => '2.0'
]; // Associative Array
// It can be nested also like php has creator, extension, versions array. $array3[php][versions][0][releaseDate]
echo $array3['php'];
$newKey = 'Javascript';
$array[$newKey] = 'ES6'; // Pushed a New Key Value into Array Dynamically

$firstname = "Peter";
$lastname = "Griffin";
$age = "41";
$result = compact("firstname", "lastname", "age"); // Create array containing variables and their values
$number = range(0,5); // Creates array from 0 to 5

$array4 = [0 => 'foo', 1 => 'bar', '1' => 'baz']; // Index 1's value will be baz, becaue it is overrode
$array5 = [true => 'a', 1 => 'b', '1' => 'c', 1.8 => 'd', null => 'e'];
print_r($array5); // Output: 1 => d, [] => e. 
// Because php automatically type casted every key to 1 and all is overriden again and again
// and null as key will be an empty string
echo $array5['']; // or $array5[null], output: e

$arry6 = ['a', 'b', 50 => 'c', 'd']; // Output: 0 => a, 1 => b, 50 => c, 51 => d
unset($arry6[50], $arry6[1]); // Removed 50 and 1 Index
unset($arry6); // Output: Undefined Variable. Unset Destroys Variable

$x = 3; 
var_dump((array) $x); // Array Casting. Output: 0 => 3. 
// Null will be an empty array if casted

/*== 1. Array Functions ==*/
$items = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
echo count($items); // Length of the Array, or sizeof()
array_push($array2, 4, 5); // Push as Last Items. Pass by Reference, It changed the original array
array_pop($items); // Remove Last Element
array_shift($items); // Remove First Element
array_unshift($items, 4); // Add at first
// After Removing, index will be reindexing auto. for array6, if we remove, then indexing will automatic not 50
// But rather than 50, if it was a string, it will not be re-indexed
// But, unset() dont reindex if we destroy any key using it
array_key_exists('a', $items); // Check if key exists in an array
array_chunk($items, 2); //  Array will be divided, 0 => [0 => 1, 1 => 2], 1 => []...
array_chunk($items, 2, true); //  Key will be reserved, 0 => [a => 1, b => 2], 1 => []...
array_combine($array1, $array2); // First Array's Value will be Key, Second's value will be Value. Length must be same.
$even = array_filter($aray1, fn($number) => $number % 2 === 0); // $number performs filter operation on value and new array return
$even2 = array_filter($aray1, fn($number) => $number % 2 === 0, ARRAY_FILTER_USE_KEY); // Now $number argument performs operation on key
$even3 = array_filter($aray1, fn($number, $key) => $number % 2 === 0, ARRAY_FILTER_USE_BOTH); // Can use both key and value now
$reIndexAfterFilter = array_values($even); // Filter dont reindex, so we can use it if reindexing need
$filterWithoutClosure = array_filter($aray1); // It will just remove falsy values from array like false, [], '', 0.0 etc
$keys = array_keys($items); // Output: 0 => a, 1 => b... Loosly Comparisn
$keys = array_keys($items, 5); // Output: 0 => e. Returned that key where value 5 found
$keys2 = array_keys($items, true); // Strict Comparisn
$mapTest = array_map(fn($number) => $number * 3, $items); // Passing single Array, so map and preserve keys
$mapTest2 = array_map(fn($number1, $number2) => $number1 * $number1, $arry1, $array2); // Mapped and Reindexed Numerically
// When we pass multiple arrays in array_map, their length should be same. If not, then shorter array will be extended with empty elements
// If no colsure argument provided, map() will simply build new array from the given array
$merged = array_merge($array1, $array2); // Reindexed if no string key. Merge Ayrras. Ex- If same key 'a' have 5 and 10, take last value just
// aray_merge_recursively()

// Reduce array in a single Value
$sum = array_reduce($array1, function($carry, $item) {
    return $carry + $item;
}, 0); // $carry is previous iteration, $item is current value, 0 is $carry's initial value

// Searching Element in Array
// array_search(mixed $needle, array $haystack, bool $strict = false): int|string|false
$searchKey = array_search('8.0', $array3); // Output: PHP, returns key of the first matching value. Case Sensitive
in_array('8.0', $array3) ;// Output: true

array_diff($array1, $array2, $array3); 
// Check if any value of $arry1 presents in $array2 and $array3, If present remove it from $array1
array_diff_assoc($array1, $array2, $array3); //Check key value pair then differ
array_diff_key($array1, $array2, $array3);
// array_diff_uassoc: diff based on closure
// array_diff_ukey()

asort($array1); // Sort by Value
ksort($array1); // Sort by Key
usort($array1, fn($a, $b) => $a <> $b); // Sort Based on Callback. 
// usort Remove Custom Keys, and Use Numeric Keys Instead

// Array Destructuring (De structure array into separate variables)
list($a, $b, $c) = $array1; // or, shorter version:
[$a, $b, $c] = $array1;
[$a, , $c] = $array1; // 2nd element is skipped
// Destructing can be from nested array also: [$a, $b , [$c, $d]]
[1 => $a, 0 => $b, 2 => $c] = $array1; // Specify Keys

// Array Columns: Array of Nested Arrays Same Column
$a = array(
  array(
    'id' => 5698,
    'first_name' => 'Peter',
    'last_name' => 'Griffin',
  ),
  array(
    'id' => 4767,
    'first_name' => 'Ben',
    'last_name' => 'Smith',
  ),);
  $last_names = array_column($a, 'last_name');
  print_r($last_names); // Array [0] => Griffin [1] => Smith

// More Function:
// array_change_key_case()	Changes all keys in an array to lowercase or uppercase
// array_count_values(): Frequency of All Elements
// array_fills(). array_fill_keys()
// array_flip()	Flips/Exchanges all keys with their associated values in an array
// array_intersect()	Compare arrays, and returns the matches (compare values only)
// array_intersect_assoc(), array_intersect_key(), array_intersect_uassoc(), array_intersect_ukey()
// array_multisort()	Sorts multiple or multi-dimensional arrays
// array_pad()	Inserts a specified number of items, with a specified value, to an array
// array_product()	Calculates the product of the values in an array
// array_rand()	Returns one or more random keys from an array
// array_replace()	Replaces the values of the first array with the values from following arrays, array_replace_recursive()
// array_reverse()	Returns an array in the reverse order
// array_slice()	Returns selected parts of an array
// array_splice()	Removes and replaces specified elements of an array
// array_sum()	Returns the sum of the values in an array
// array_unique()	Removes duplicate values from an array
// array_walk()	Applies a user function to every member of an array, but on single array and change original array, no return value
// current()	Returns the current element in an array
// end()	Sets the internal pointer of an array to its last element
// extract()	Imports variables into the current symbol table from an array
// natcasesort()	Sorts an array using a case insensitive "natural order" algorithm
// natsort()	Sorts an array using a "natural order" algorithm
// shuffle()	Shuffles an array
// sizeof()	Alias of count()