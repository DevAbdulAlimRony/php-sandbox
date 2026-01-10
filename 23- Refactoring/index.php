<?php
//** 1. Composing Methods: */
//* 1. Extract Method: Rather than writting so many lines in one method of a class, extract them into different methods.
// Be sure to give the new method a name that describes the method’s purpose: createOrder(), renderCustomerInfo(), etc.
// function printOwing() {
//   $this->printBanner();
//   $this->printDetails($this->getOutstanding());
// }

//* 2. Inline Method: Minimize multiple methods into one method if extra methods feel unnecessary.
// Opposite to the extract method.
// return ($this->numberOfLateDeliveries > 5) ? 2 : 1;

//* 3. Extract Variables
// Problem: if (($platform->toUpperCase()->indexOf("MAC") > -1) && ($browser->toUpperCase()->indexOf("IE") > -1) && $this->wasInitialized() && $this->resize > 0)
// Solution: $isMacOs = $platform->toUpperCase()->indexOf("MAC") > -1; $isIE = $browser->toUpperCase()->indexOf("IE")  > -1; $wasResized = $this->resize > 0; if ($isMacOs && $isIE && $this->wasInitialized() && $wasResized) 

//* 4. Inline Temp:
// Problem: $basePrice = $anOrder->basePrice();  return $basePrice > 1000;
// Solution: return $anOrder->basePrice() > 1000;
// Opposite of Extract Variables.

//* 5. Replcae Temp with Query: If temp expression for later use in multiple place, make it a method
// Problem: $basePrice = $this->quantity * $this->itemPrice; basePrice will be used in three places
// Solution: function basePrice() { return $this->quantity * $this->itemPrice; }

//* 6. Split Temporary Variable: Use different variables for different values. 
// Problem: $temp = 2 * ($this->height + $this->width); $temp = $this->height * $this->width;
// Solution: $perimeter = 2 * ($this->height + $this->width); $area = $this->height * $this->width;

//* 7. Remove assignments to parameters: 
// Problem: function discount($inputVal, $quantity) {  if ($quantity > 50) {  $inputVal -= 2;}
// Solution: function discount($inputVal, $quantity) { $result = $inputVal; if ($quantity > 50) { $result -= 2; }

//* 8. Remove assignments to parameters: 
// Let's say, we have so many local variables in a method. We can take a class with those variables as property in a compute() method that use that object rather than taking all variables in the method directly.
// Ex- Rather than doing calculations in a method directly, we took a calculation service class and use that object's method.

//* 8. Substitute Algorithm: 
// If you want different algorithom for a method, just remove old code and write new algorithm again rather than taking another method.

//** 1. Moving Features Between Objects: */
//* 1. Move Method: A method is used more in another class than in its own class.
// Create a new method in the class that uses the method the most, then move code from the old method to there. Turn the code of the original method into a reference to the new method in the other class or else remove it entirely.

//* 2. Move field: Same concept as move method.
// Create a field in a new class and redirect all users of the old field to it.

//* 3. Extract Class: A class is doing too much work.
// create a new class and place the fields and methods responsible for the relevant functionality in it.

//* 4. Inline Class: A class that isn't doing enough to justify its existence.
// Move all its features into another class and delete it.

//* 5. Hide Delegate: When a client frequently invokes methods on a delegate returned by another object.
// Provide a simple method in the original object that delegates to the delegate. Then change all clients
// Ex. client.getManager().getDepartment().getName();
// Solve by adding a method in client: client.getDepartmentName() that does the delegation internally.
// Though its seems like laravel's relationship like users.department.subjects, but delegation only needs when client code depends on internal structure, part of business logic.
// So, laravel's that type relationships dont need delegation hiding.

//* 6. Remove Middle Man: A class has too many methods that simply delegate to other objects.
// Delete these methods and force the client to call the end methods directly.
// Its the opposite of hide delegate, sometimes we dont need to overdo it.
// Ex- A User has a Profile, and Profile has an Address. Someone tried to “hide everything”… and overdid it.

//* 7. Introduce Foreign Method: A utility class doesn’t contain the method that you need and you can’t add the method to the class.
// Add the method to a client class and pass an object of the utility class to it as an argument.
// Ex: You frequently need to “Capitalize a person’s full name properly. $formatted = ucwords(strtolower($name))
// Raher than always  doing that, create a method in a client class: class StringHelper { public static function formatPersonName($name) { return ucwords(strtolower($name)); } then use it whenever needed- StringHelper::formatPersonName($name);

//* 8. Introduce Local Extension: A utility class doesn’t contain some methods that you need. But you can’t add these methods to the class.
// Create a new class containing the methods and make it either the child or wrapper of the utility class.
// Ex: You use a Money object from a third part library which has amount, current but you need addTax(), return() etc. You can't modify the original money class.
// You create a local wrapper / subclass. class ExtendedMoney extends Money{} and use ExtendedMoney everywhere rather than Money.

//** 2. Organizing Data: */
//* 1. Self Encapsulate Field: You use direct access to private fields inside a class, use getter and setter.
// You can perform complex operations when data in the field is set or received.
// Lazy initialization and validation of field values are easily implemented inside field getters and setters.
// We can redefine getters and setters in subclasses.

//* 2. Replace Data Value with Object: A field contains multiple data items.
// A class (or group of classes) contains a data field. The field has its own behavior and associated data.
// Create a new class, place the old field and its behavior in the class with self encapsuate field making getters, and store the object of the class in the original class.

//* 3. Change Value to Reference: 
// You have many identical instances of a single class that you need to replace with a single object.
// Convert the identical objects to a single reference object.
// Use  Replace Constructor with Factory Method on the class from which the references are to be generated.
// Laravel Exmp: We are accessing a order's shipping address- $order->user->address;
// What if User updates address later, Old orders now show wrong delivery address.
// Correct way orders should store address for each order. Maybe from addresses table as reference.

//* 3. Change Reference to Value: Opposite of Change Value to Reference.
// You have a reference object that’s too small and infrequently changed to justify managing its life cycle.
// Turn it into a value object.

//* 4. Replace Array with Object: You have an array that contains various types of data.
// Replace the array with an object of a class that will have separate fields for each element.
$transaction = ['deposit', 5000, '2025-01-01'];

if ($transaction[0] === 'deposit') {
    $balance += $transaction[1];
}
// Solution:
class Transaction
{
    public function __construct(
        private string $type,
        private float $amount,
        private DateTime $date
    ) {
        if ($amount <= 0) {
            throw new Exception('Invalid amount');
        }
    }

    public function apply(float $balance): float
    {
        return $this->type === 'deposit'
            ? $balance + $this->amount
            : $balance - $this->amount;
    }
}
$transaction = new Transaction('deposit', 5000, new DateTime());
$balance = $transaction->apply($balance);

//* 5. Change Unidirectional to Bidirectional Association: You have two classes that each need to use the features of the other, but the association between them is only unidirectional.
// Add the missing association to the class that needs it.

//* 6. Change Bidirectional Association to Unidirectional
// You have a bidirectional association between classes, but one of the classes doesn’t use the other’s features.
// Remove the unused association.
// Don't need hasMany relationship in laravel, never used- just remove it.

//* 7. Replace Magic Number with Symbolic Constant
// $mass * $height * 9.81, make it: define("GRAVITATIONAL_CONSTANT", 9.81); $mass * $height * GRAVITATIONAL_CONSTANT;

//* 8. Encapsulate Field: Make a field private and create getter and setter methods to access it.
// If there is any logic to be added when getting or setting the field, it can be done in these methods.
// You can also perform complicated operations related to access to object fields.
// public array $items = []; - Anyone can delete everything, No Validation
class BankAccount
{
    public float $balance = 0;
}

$account = new BankAccount();
$account->balance = -5000;   // ❌ illegal but allowed

class BankAccount2
{
    private float $balance = 0;

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $amount): void
    {
        if ($amount < 0) {
            throw new Exception('Balance cannot be negative');
        }

        $this->balance = $amount;
    }
}

$account2 = new BankAccount2();
$account2->setBalance(1000);     // ✅ valid
echo $account2->getBalance();    // 1000
$account2->setBalance(-500);     // ❌ exception

//* 9. Encapsulate Collection: A class contains a collection field and a simple getter and setter for working with the collection.
// Make the getter-returned value read-only and create methods for adding/deleting elements of the collection.
class Cart
{
    private array $items = [];

    // READ-ONLY access
    public function getItems(): array
    {
        return array_values($this->items); // copy
    }

    // Controlled add
    public function addItem(string $item): void
    {
        if (in_array($item, $this->items)) {
            throw new Exception("Item already in cart");
        }

        $this->items[] = $item;
    }

    // Controlled remove
    public function removeItem(string $item): void
    {
        $key = array_search($item, $this->items);

        if ($key === false) {
            throw new Exception("Item not found");
        }

        unset($this->items[$key]);
    }
}

//* 10. Replace Type Code with Class or subclass or state/strategy.
// Type code occurs when, instead of a separate data type, you have a set of numbers or strings that form a list of allowable values for some entity.
// Create a new class and use its objects instead of the type code values.
class Payment
{
    public string $type;

    public function calculateFee(float $amount): float
    {
        if ($this->type === 'cash') {
            return 0;
        } elseif ($this->type === 'card') {
            return $amount * 0.02;
        } elseif ($this->type === 'bkash') {
            return $amount * 0.015;
        }

        throw new Exception('Invalid payment type');
    }
} // Rather Than doing it:

abstract class Payment2
{
    abstract public function calculateFee(float $amount): float;
}
class CashPayment extends Payment2
{
    public function calculateFee(float $amount): float
    {
        return 0;
    }
}
class CardPayment extends Payment2
{
    public function calculateFee(float $amount): float
    {
        return $amount * 0.02;
    }
}
class BkashPayment extends Payment2
{
    public function calculateFee(float $amount): float
    {
        return $amount * 0.015;
    }
}
$payment = new CardPayment();
$fee = $payment->calculateFee(1000);

//* 10. Replace Subclass with Fields.
// You have subclasses differing only in their (constant-returning) methods.
// Replace the methods with fields in the parent class and delete the subclasses.
abstract class Employee
{
    abstract public function getType(): string;
    abstract public function getSalaryMultiplier(): float;
}
class Manager extends Employee
{
    public function getType(): string
    {
        return 'manager';
    }

    public function getSalaryMultiplier(): float
    {
        return 2.0;
    }
}
class Employee2
{
    public function __construct(
        private string $type,
        private float $salaryMultiplier
    ) {}

    public function getType(): string
    {
        return $this->type;
    }

    public function getSalaryMultiplier(): float
    {
        return $this->salaryMultiplier;
    }
}

//** 3. Simplifying Conditional Expressions: */
//* 1. Decompose Conditional: You have a complex conditional (if-then/else or switch), decompose.
// if ($date->before(SUMMER_START) || $date->after(SUMMER_END)), make it a method and call- if (isSummer($date)).

//* 2. Consolidate Conditional Expression: You have multiple conditionals that lead to the same result or action.
// Consolidate all these conditionals in a single expression.

//* 3. Consolidate Duplicate Conditional Fragments: Identical code can be found in all branches of a conditional.
// Move the code outside of the conditional.
if ($a > 3) {
  $total = $price * 0.95;
  return 10;
} else {
  $total = $price * 0.98;
  return 10;
}

// Solution:
if ($a > 3) {
  $total = $price * 0.95;
} else {
  $total = $price * 0.98;
}
return 10;

//* 4. Remove Control Flag: You have a boolean variable that acts as a control flag for multiple boolean expressions.
// Instead of the variable, use break, continue and return.

//* 5. Replace Nested Conditional with Guard Clauses
// You have a group of nested conditionals and it’s hard to determine the normal flow of code execution.
// Isolate all special checks and edge cases into separate clauses and place them before the main checks.
//  Ideally, you should have a “flat” list of conditionals, one after the other.
// Rather than else then inside it if else, just use flat if conditional with return value.

//* 6. Replace Conditional with Polymorphism
// You have a conditional that performs various actions depending on object type or properties.
// Create subclasses matching the branches of the conditional. In them, create a shared method and move code from the corresponding branch of the conditional to it. 

//* 7. Introduce Null Object: Instead of null, return a null object that exhibits the default behavior.
// $customer = ($order->customer !== null) ? $order->customer : new NullCustomer;
// Why Need- Dozens of checks for null make your code longer and uglier.

//* 7. Introduce Assertion: For a portion of code to work correctly, certain conditions or values must be true.
// Replace these assumptions with specific assertion checks.
function transferOld(User $from, User $to, float $amount)
{
    // Assumption: $amount is always > 0
    // Assumption: sender always has balance

    $from->balance -= $amount;
    $to->balance += $amount;

    $from->save();
    $to->save();
}
function transferNew(User $from, User $to, float $amount)
{
    assert($amount > 0, 'Transfer amount must be positive');
    assert($from->balance >= $amount, 'Insufficient balance');

    $from->balance -= $amount;
    $to->balance += $amount;

    $from->save();
    $to->save();
}
// Now, Invalid input is caught immediately, Error message explains what went wrong.

//** 4. Simplifying Method Calls: */
//* 1. Rename Method: The method name should explain what the method does, doesnt matter how long the name takes.

//* 2. Add Parameter: A method doesn’t have enough data to perform certain actions.
// Create a new parameter to pass the necessary data.

//* 3. Remove Parameter: A parameter isn’t used in the body of a method.
// Remove the unused parameter.

//* 4. Separate Query from Modifier: If method return a value and also changes something inside an object.
// Split the method into two separate methods.
// Split getTotalOutstandingAndSetReadyForSummaries() into getTotalOutstanding() and setReadyForSummaries().

//* 5. Parameterize Method: Multiple methods perform similar actions.
// Combine these methods by using a parameter that will pass the necessary special value.
// fivePercentRise() tenPercentRise() - make it: rise(percentage)

//* 5. Replace Parameter with Explicit Methods: A method is split into parts, each of which is run depending on the value of a parameter.
// Extract the individual parts of the method into their own methods and call them instead of the original method.
function setValue($name, $value) {
  if ($name === "height") {
    $height = $value;
    return;
  }
  if ($name === "width") {
    $width = $value;
    return;
  }
  assert("Should never reach here");
}

// Solution:
function setHeight($arg) {
  $height = $arg;
}
function setWidth($arg) {
  $width = $arg;
}

//* 5. Preserve Whole Object: You get several values from an object and then pass them as parameters to a method.
// Instead, try passing the whole object.

//* 6. Replace Parameter with Method Call:
class Order
{
    public function applyDiscount(float $totalPrice): float
    {
        return $totalPrice * 0.9; // 10% discount
    }

    public function getTotal(): float
    {
        return 1000;
    }
}

// Usage
$order = new Order();
$total = $order->getTotal();
$final = $order->applyDiscount($total);

// Solution:
class Order2
{
    public function applyDiscount(): float
    {
        return $this->getTotal() * 0.9;
    }

    public function getTotal(): float
    {
        return 1000;
    }
}
// Usage
$order = new Order2();
$final = $order->applyDiscount();


//* 7. Introduce Parameter Object: Your methods contain a repeating group of parameters.
// Replace these parameters with an object.

//*8: Remove Setting Method: If a field should never change after object creation,
// don’t provide a setter for it.
class Order3
{
    private int $id;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
} // Now, anyone can change the order identity, breaks identity and data integrity.
// Solution: 
class Order4
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}

//*8: Hide Method: A method isn’t used by other classes or is used only inside its own class hierarchy.
// Make the method private or protected.

//*8: Replace Constructor with Factory Method: If a constructor does too much work (logic, decisions, validation, setup),
// Move that logic into a factory method and keep the constructor simple.
class User
{
    private string $email;
    private string $role;
    private bool $active;

    public function __construct(string $email, bool $isAdmin)
    {
        $this->email = strtolower(trim($email));

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email');
        }

        if ($isAdmin) {
            $this->role = 'admin';
            $this->active = true;
        } else {
            $this->role = 'user';
            $this->active = false;
        }
    }
}
// Solution
class User2
{
    private string $email;
    private string $role;
    private bool $active;

    // Constructor is now simple and predictable
    private function __construct(string $email, string $role, bool $active)
    {
        $this->email = $email;
        $this->role = $role;
        $this->active = $active;
    }

    // Factory method for normal users
    public static function createUser(string $email): self
    {
        return new self(
            self::normalizeEmail($email),
            'user',
            false
        );
    }

    // Factory method for admin users
    public static function createAdmin(string $email): self
    {
        return new self(
            self::normalizeEmail($email),
            'admin',
            true
        );
    }

    private static function normalizeEmail(string $email): string
    {
        $email = strtolower(trim($email));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email');
        }

        return $email;
    }
}

//*9: Replace Error Code with Exception: A method returns a special value that indicates an error.
// Throw an exception instead.

//*10: Replace Exception with Test: You throw an exception in a place where a simple test would do the job
// Replace the exception with a condition test via if.

//** 5. Dealing with Generalization: */
//* 1. Pull Up Field: Two classes have the same field, Remove the field from subclasses and move it to the superclass.
//* 2. Pull Up Method: Your subclasses have methods that perform similar work. Make the methods identical and then move them to the relevant superclass.
//* 3. Your subclasses have constructors with code that’s mostly identical. Create a superclass constructor and move the code that’s the same in the subclasses to it. Call the superclass constructor in the subclass constructors.
//* 4. Push Down Method, Push Down Field: Opposite Concepts.
//* 5. Extract Subclass: A class has features that are used only in certain cases. Create a subclass and use it in these cases.
//* 6. Extract Superclass: You have two classes with common fields and methods. Create a shared superclass for them and move all the identical fields and methods to it.
//* 7. Extract Interface: Multiple clients are using the same part of a class interface or  part of the interface in two classes is the same. Move this identical portion to its own interface.
//* 8. You have a class hierarchy in which a subclass is practically the same as its superclass. Merge the subclass and superclass.
//* 9. Form Template Method: Your subclasses implement algorithms that contain similar steps in the same order. Move the algorithm structure and identical steps to a superclass, and leave implementation of the different steps in the subclasses.
//* 10. Replace Inheritance with Delegation: You have a subclass that uses only a portion of the methods of its superclass, Create a field and put a superclass object in it, delegate methods to the superclass object, and get rid of inheritance.
class EmailService
{
    public function sendEmail(string $to, string $message): void
    {
        echo "Email sent to $to: $message";
    }

    public function connectSMTP(): void
    {
        echo "SMTP connected";
    }

    public function logEmail(): void
    {
        echo "Email logged";
    }
}

class UserNotification extends EmailService
{
    public function notify(string $email): void
    {
        $this->sendEmail($email, 'Welcome to CRM'); // Using just sendEmail
    }
}
// Solution:
class EmailService2
{
    public function sendEmail(string $to, string $message): void
    {
        echo "Email sent to $to: $message";
    }
}
class UserNotification2
{
    private EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function notify(string $email): void
    {
        $this->emailService->sendEmail($email, 'Welcome to CRM');
    }
}
//* 11: Replace Delegation with Inheritance: A class contains many simple methods that delegate to all methods of another class. 
// Make the class a delegate inheritor, which makes the delegating methods unnecessary.

//** 10. Code Smells: */
//* 1. Long Method Bloater: any method longer than ten lines should make you start asking questions.
// something is always being added to a method but nothing is ever taken out, that's bad.
// Tratment: Extract Method, if you feel the need to comment on something inside a method, you should take this code and put it in a new method.
// Even a single line can and should be split off into a separate method, if it requires explanations.

//* 2. Large Class Bloater: A class contains many fields/methods/lines of code.
// Treatment: Extract class, Extract Sub class, Extract Interface.

//* 2. Primitive Obsession: 