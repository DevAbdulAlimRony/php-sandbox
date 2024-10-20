<?php
declare(strict_types = 1);
namespace App\Basic;
use App\CustomException\Customer;

//* Class naming upon file name is recommended, but not required
// Single Class for a Single File is Standard, Nothing else outside the class
class Transaction{
    //* Access Modifiers or Visibility: public, private, protected:
    // public: Everyone interating with the objects even outside the class
    // Private: Only accessible within the class itself

    //* Class or Instance Properties (Need to Create Object to Access):
    public $description; // Access: $obj->description
    private float $amount; // Type Hinting Recommended
    // If we var_dump description, will get NULL, but for being type hinted amount will throw error
    // If we var_dump an object of this class, it will show amount's value uninitialized
    public float $amount2 = 15; // Default Value Assigned (Hard Coded, Not Recommended)
    public ?Customer $customer = null; // Object as a Property
    // The  ?  before the type  Customer  indicates that this property can either hold an instance of the  Customer  class or be  null

    //* Static Property (No Need to Create Object to Access, Think as Global Variable)
    // If one instance modifies the static property, the change is reflected across all instances.
    public static $count = 0; // or, static public $count.
    // Accessing Outside: $obj::$count, Transaction:$count
    // Accessing Inside: self::$count, Transaction::$count
    // self refers to the current Class, We can use it as Type Hint also
    // Not Accessible: $this->count (static dont belong to Object, Belong to Class Itself)
    // Use Cases: Counter, Cache Value, To Make Singleton Pattern

    //* Class Constants:
    public const STATUS_PAID = 'paid'; // Access: Transaction::STATUS_PAID, self::STATUS_PAID, $obj::STATUS_PAID
    public const STATUS_PENDING = 'pending';
    public const STATUS_DECLINED = 'declined';
    public const ALL_STATUS = [
        self::STATUS_PAID => 'Paid',
        self::STATUS_PENDING => 'Pending',
        self::STATUS_DECLINED => 'Declined',
    ];
    // Lookup Table (We will check in setter setStatus() if appropriate argument passed so that setter calling must pass valid argument
    // But Transaction class should be just for Transaction, We can create a new Class Status 
    // and Define them there like PAID, PENDING. Access: STATUS::PAID (More Organized and Readable). - ENUM Class

    //* Constructor: Automatically called when an object of a class is created
    // To Initialize Our Properties, We can use constructor magic method
    public function __construct(float $amount2, $description){
        $this->amount2 = $amount2;
        $this->description = $description;
        self::$count++; // When we create a object, this static property will increment
        $this->setStatus(self::STATUS_PENDING);
    } // If we remove access modifier, php will take those as public automatically

    // Constructor Property Promotion (ShortHand Version, Recommended)
    // public function __construct(
    //     private float $amount,
    //     private string $description
    // ){}
    // If we declare like that with access modifier, PHP will automatically declare poperty and assign it, No need to declare property and then again assign it
    // Here, We cant type hint property as callable
    // Also in shorthand, we can mix with property assigning and without assigning
    // We can set default value for promoted property
    // With Default Value can use nullable type: private ?string $description = null

    //*Methods:
    public function addTax(float $rate): void{
        $this->amount += $this->amount * $rate / 100;
    }
     public function applyDiscount(float $rate){
        $this->amount -= $this->amount * $rate / 100;
    }

    // To Use Method Chaining, return Object (Type hint by Class Name or self):
    public function addTax2(float $rate): Transaction{
        $this->amount += $this->amount * $rate / 100;
        return $this;
    }
    public function applyDiscount2(float $rate): self{
        $this->amount -= $this->amount * $rate / 100;
        return $this;
    }

    //* Static Methods: When Method dont Depend on Object (Use Ex: Factory Pattern)
    // Accessing is same as static property
    // We can access static method non-statically ($object->getCount(). Not recommended, Make confusion)
    // If we use static in callback, we cant access $this. Ex- array_map(static function(){}, $array)
    // Static methods have micro optimization over regular, but it's purpose should not be optimization. 
    // Use when you really need it, use when dont want to access $this in that method

    //* Encapsulation: Data Hiding, Controlled Access, Increased Security
    // We can set as private and make getter setter if Need, But That Means the same thing as public, right?.
    // So geteters and setters don't always break the encapsulation.
    // But sometimes, getter and setter make sense like If we need to do something before accessing the property or before setting the property
    // Dont Define Getter and Setter for Every Property Unless You actually Need Them
    public function getAmount(): float{
        return $this->amount;
    }
    public function setStatus(string $status): self{
        if(! isset(self::ALL_STATUS[$status])){
            throw new \InvalidArgumentException('Invalid Status');
        }
        $this->status = $status;
        return $this;
    }

    // Another Way Accessing Private
    public function copyFrom(Transaction $transaction){
        var_dump($transaction->amount);
    } // Now, we can access copyFrom() outside the class, so again private property is accessible

    //* Encapsulation hides internal information, abstraction hides actual implementation

    //* Annnymous Class: Also Discussed in index.php
    public function annonymous(): object{
        return new class($this->amount) extends Transaction {
            public function __construct(public float $amount){
                // parent::__construct($amount);
                // We extends Transaction class so that We can use its property
            }
        };
    }
    // Main Use Case: Testing etc.

    //* DockBlock:
    /**
     * Can be Used to automatically generate api documentation
     * Enhanced Functionality, Descriptive Documents Comment
     * @param - param tag use to say about parameters
     * @return - return tag for return type
     * @throws - throws tag say about exception
     * @var - properties type
     * @property - which property available
     * @method - which method available
     */
}   