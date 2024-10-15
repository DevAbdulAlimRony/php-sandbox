<?php
declare(strict_types=1);
// Class and Objects
// Class naming upon file name is recommended, but not required
// Single Class for a Single File is Standard, Nothing else outside the class
class Transaction{
    // Declaring Properties with Access Modifiers: public, protected, private
    // public: everyone interating with the objects even outside the class
    // Private: Only accessible within the class itself
    public $description; // We can access it by obj->description
    private float $amount; // Type Hinting not required, recommended
    // If we var_dump description, will get NULL, but for being type hinted amount will throw error
    // If we var_dump an object of this class now, it will show amount's value uninitialized
    public float $amount2 = 15; // Default Value Assign will work, but it is hard coding for a class, not recommended
    public ?Customer $customer = null;

    // Class Constant: 
    // Calling using Class: Transaction::STATUS_PAID;
    // Calling Using Object: $transaction::STATUS_PAID;
    // Accessing within Class: using class or self::STATUS_PAID;
    // self refers to the current class
    public const STATUS_PAID = 'paid';
    public const STATUS_PENDING = 'pending';
    public const STATUS_DECLINED = 'declined';
    public const ALL_STATUS = [
        self::STATUS_PAID => 'Paid',
        self::STATUS_PENDING => 'Pending',
        self::STATUS_DECLINED => 'Declined',
    ]; // Lookup Table (We will check in setter setStatus() if appropriate argument passed so that setter calling must pass valid argument
    // But Transaction class should be just for Transaction, We can create a new Class Status 
    //and Define them there like PAID, PENDING. Access: STATUS::PAID (More Organized and Readable). - ENUM Class

    // To Initialize Our Properties, We can use constructor (also called magic method):
    public function __construct(float $amount, $description){
        $this->amount = $amount;
        $this->setStatus(self::STATUS_PENDING);
        $this->description = $description;
    } // If we remove access modifier, php will take those as public automatically

    // Constructor Property Promotion (ShortHand Version)
    // public function __construct(
    //     private float $amount,
    //     private string $description
    // ){}
    // If we declare like that with access modifier, PHP will automatically declare poperty and assign it, No need to declare property and then again assign it
    // Here, We cant type hint property as callable
    // Also in shorthand, we can mix with property assigning and without assigning
    // We can set default value for promoted property
    // With Default Value can use nullable type: private ?string $description = null
    
    // Methods
    public function addTax(float $rate){
        $this->amount += $this->amount * $rate / 100;
    }
     public function applyDiscount(float $rate){
        $this->amount -= $this->amount * $rate / 100;
    }

    // Rather than Doing like above, We can return $this so that We can use method chaining
    public function addTax2(float $rate): Transaction{
        // We used return type classname, also can use 'self'
        $this->amount += $this->amount * $rate / 100;
        return $this;
    }

    public function applyDiscount2(float $rate): Transaction{
        $this->amount -= $this->amount * $rate / 100;
        return $this;
    }

    // As Amount is private, We can create a getter function to access it
    public function getAmount(): float{
        return $this->amount;
    }

    // Setter for status
    public function setStatus(string $status): self{
        if(! isset(self::ALL_STATUS[$status])){
            throw new \InvalidArgumentException('Invalid Status');
        }
        $this->status = $status;
        return $this;
    }

    // Destructor Magic Method
    // A destructor is called when the object is destructed or the script is stopped or exited.
    //  If you create a __destruct() function, PHP will automatically call this function at the end of the script. 
    public function __destruct(){
         echo "Destructor Calling";
         // It is used for clean up, database connection etc. Not Much Used
         // Ex: Closing Database Connection When Long Script
    }
}