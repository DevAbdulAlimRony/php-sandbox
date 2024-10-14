<?php
/*== 1. Control Structure ==*/
// if, else, elseif, else if. Another Approach: if: elseif: endif;
// The endif keyword is used to mark the end of an if conditional which was started with the if():

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
// No Default Value System. You have to specify all cases. If Not, it will through error
// Switch does loose comparisn, match does strict comparisn

// Use Cases:
//  A for loop is generally designed for cases where the starting condition, iteration, and stopping condition are all known upfront.
//  The While loop is appropriate for dynamic condition, When the number of iterations is not known in advance and depends on a condition.
// while It provides flexibility when iterating over database results or user input.
//  In a situation where you want to ensure that the loop runs at least once, a do-while loop is ideal.
// foreach is designed for iterating over arrays or objects and is more readable and less error-prone than using a for loop when you just need to access each element in a collection.
// Use Switch When you need to check a variable against many different values and execute different code blocks depending on the match.

// Real Example:
// For Loop: pagination
// while: Data Fetching-
$query = "SELECT * FROM orders WHERE customer_id = 123";
$result = $conn->query($query);
// Keep fetching rows until there are no more results, We dont know how many row so we didnt use for loop
while ($order = $result->fetch_assoc()) {
    echo "Order ID: " . $order['order_id'] . "<br>";
    echo "Total: " . $order['total'] . "<br><br>";
}

// do...while:
$maxAttempts = 3;
$attempts = 0;
$isLoggedIn = false;

do {
    // Simulating a login attempt (this would usually involve checking a database)
    $username = readline("Enter username: ");
    $password = readline("Enter password: ");
    
    // Simulate correct credentials
    if ($username === 'user' && $password === 'password') {
        $isLoggedIn = true;
        echo "Login successful!\n";
    } else {
        $attempts++;
        echo "Invalid credentials. Try again.\n";
    }
} while (!$isLoggedIn && $attempts < $maxAttempts);

if (!$isLoggedIn) {
    echo "Too many failed attempts. Access denied.\n";
}

// Switch..Case
$userRole = 'editor';
switch ($userRole) {
    case 'admin':
        echo "Welcome to the Admin Dashboard!";
        break;
    case 'editor':
        echo "Welcome to the Editor's Dashboard!";
        break;
    case 'subscriber':
        echo "Welcome to the Subscriber's Dashboard!";
        break;
    case 'guest':
        echo "Welcome, Guest! Please log in to access more features.";
        break;
    default:
        echo "Unknown role. Please contact support.";
        break;
}

// Match Expression: Returning a message based on HTTP status code
$statusCode = 404;

$message = match($statusCode) {
    200 => 'OK',
    201 => 'Created',
    400 => 'Bad Request',
    404 => 'Not Found',
    500 => 'Internal Server Error',
    default => 'Unknown Status',
};

echo $message;  // Output: Not Found
?>