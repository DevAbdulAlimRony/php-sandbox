<?php
//** 1. Code Smells: */


//** 2. Composing Methods: */
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