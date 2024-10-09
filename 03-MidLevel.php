<?php
/*== 1. Control Structure ==*/
// if, else, elseif, else if. Another Approach: if: elseif: endif;
// The endif keyword is used to mark the end of an if conditional which was started with the if(...):

/*== 2. Loop ==*/
// While Loop or while: endwhile;
$i = 0;
while($i <= 15){ // as long as valid, run $i++
    echo $i++;
}
// break, continue statement
// do...while (print first initial value, then check condition)
$i = 0;
do{
    echo $i++;
}while($i <= 15);
// For Loop:
for ($x = 0; $x <= 10; $x++) {
  echo "The number is: $x <br>";
} // for (; ; )- not required, can be empty
// for ($x = 0; print $x; $x <= 10; $x++) // Can Have Multiple Expression
// We can run for loop on array, string
// Alternative: for(): endfor;
// When we use count() or strlen() in loop, it will run each time the loop run, performance issue.
// Solve: length determine and take it into a variable then use that variable in loop, so count() function just run once.

// foreach loop
$colors = array("red", "green", "blue", "yellow");
foreach ($colors as $x) {
  echo "$x <br>";
}
// $x this variable dont get destroyed outside loop
echo $x; // we still get last item outside of the loop
unset($x); // But, after loop if we unset it, it will be destroyed
// as $x => $y when we loop on associative array or on object for key value pairs 
// foreach: endforeach;
// Changes in loop wont affect the original var, but if we pass by reference it will change original
foreach ($colors as &$x) {
  if ($x == "blue") $x = "pink";
}

/*== 3. Switch Case Statement ==*/
// Multiple Strategy or Common Code Block (Do a Common Thing for Multiple Cases)

/*== 4. Match Expression (Introduced in PHP8): Work like Switch Case ==*/
// Rather than Case, we are just using key value pair
$paymentStatus = 1;
$paymentStatusDisplay = match($paymentStatus){
    1 => 'Paid', // we can have a function here that returns a value
    2 => 'Payment Declined',
    3,4 => 'Rejected' // fall throgh strategy, if match 3 o4 4 show rejected
}; // Return: Paid
echo $paymentStatusDisplay;
// dont need break in match expression, switch always need break
// We can give any default value likeswitch, you have to specify all cases. If Not, it will through error
// Switch does loose comparisn, match does strict comparisn