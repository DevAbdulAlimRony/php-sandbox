<?php
namespace App\Inheritence;

//* ToasterPro inherits all public and protected properties and methods from Toaster
// PHP does not support multiple inhertence, we can do multi level inheritence instead
class ToasterPro extends Toaster{
    public int $size = 4;

    //* By Default, It will not call Parent Constructor
    // You dont have to have a constructor in parent class in order to have a constructor in child class
    // constructor signature must not be compatible with parent constructor
    public function __contruct(string $x, string $y){
        parent::__construct($x); // Calling Parent Constructor, Always put on top unless No Pre Logic
        $this->size = 4; // override
        // If we would call parent constructor after size =4, It will be reset to 2 from parent.
    }

    //* Method Override (When You need other custom logic)
    // Method Signature must be compatible as Parent, If not will get Fatal error
    // It is better to match the parameter name, not required
    public function addSlice(string $slice): void{
        parent::addSlice(4); // We copied same functionality just to show use of parent
    }
    
    public function toastBagel(){
        foreach($this->slices as $i => $slice){
           echo ($i + 1) . ': Toasting ' . $slice . PHP_EOL;
        }
    }

    //* When Inheritence is Bad Idea:
    // If It can break encapsulation
    // When You are inhereting, you are inhereting all the props and methods of parent class, doesn't matter it needs or doesn't need in Child Class
    // Inheritence creates tight coupling between parent and child classes
    // Tight coupling refers to a situation where two or more software components are closely connected and depend on each other to function properly. 
    // Loose coupling, on the other hand, means that the components are less dependent on each other and can operate more independently.
}  


// Composition Vs Inheritence
// Lets Say, we need a calculation method in multiple places. We can create a parent class only for that method and can inherit
// But this is not the right way. Inheritencae is not for code reuse.
// This is where composition comes in. Instead of using inheritence, we can accept this as a dependency via construcor.
// Use Inheritence if it is Is-A relationship. Like Cat is a Animal.
// Use Composition if it is Has-A relationship like Admin has a Common.
// But in some cases, for Is-A relationship, Inheritence can be a bad idea.
// Exmp: class CreditCardPayment() extends Payment, class CashPayment() extends Payment , class Payment(). But if 6 months later, we need CryptoPayment that does not need  a lot of functionality that Payment class has.

//  Do few checks before deciding to use inheritence or composition:
    // 1. What is the relationship? is-a or has-a
    // 2. Inherits useless methods/properties?
    // 3. Are classes substituable?

//  Writting Unit tests is easier with Composition.
// In some cases, when using Composition, it make sense to use Interfaces.
class OrderServiceOld {
    private StripePayment $payment;

    public function __construct() {
        $this->payment = new StripePayment;
    }

    public function checkout(float $amount) {
        $this->payment->charge($amount);
    }
}
// This is a tight coupling.
// You cannot replace Stripe with bKash / Nagad / PayPal without editing the class.
// Solution with Interface:

interface PaymentGateway {
    public function charge(float $amount): bool;
}
class StripePayment implements PaymentGateway {
    public function charge(float $amount): bool {
        // Stripe API call
        return true;
    }
}
class BkashPayment implements PaymentGateway {
    public function charge(float $amount): bool {
        // bKash API call
        return true;
    }
}
class NagadPayment implements PaymentGateway {
    public function charge(float $amount): bool {
        // Nagad logic
        return true;
    }
}
class OrderService
{
    public function __construct(
        private PaymentGateway $payment   // Composition via interface
    ) {}

    public function checkout(float $amount)
    {
        $this->payment->charge($amount);
    }
}

// $order = new OrderService(new BkashPayment());
// $order->checkout(2000);

// Without Interface -	With Interface
// Hard-coded to one payment type -	Any payment type can be plugged in
// Can't test without real API -	Mock can replace real gateway
// Difficult to change -	Zero modification inside main class
// Violates OCP -	Follows open–closed principle
// High coupling - Low coupling

// Another Example
// class FileLogger implements Logger {  }
// class DatabaseLogger implements Logger {  }
// class SlackLogger implements Logger {  }
// class TelegramLogger implements Logger { }


