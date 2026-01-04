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

//** 10. Code Smells: */
//* 1. Long Method Bloater: any method longer than ten lines should make you start asking questions.
// something is always being added to a method but nothing is ever taken out, that's bad.
// Tratment: Extract Method, if you feel the need to comment on something inside a method, you should take this code and put it in a new method.
// Even a single line can and should be split off into a separate method, if it requires explanations. 

//* 1. Large Class Bloater: A class contains many fields/methods/lines of code.
// Treatment: Extract class, Extract Sub class, Extract Interface.