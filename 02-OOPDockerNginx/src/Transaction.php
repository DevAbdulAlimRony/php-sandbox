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

    // Static Properties
    public static $count = 0; // or, static public $count (not standard), can think as global variable
    // We dont need object to access static methods and properties outside of the class
    // Accessing Outside: $obj::$count, Transaction::$count
    // Accessing Inside Class: self::$count or using class name
    // static dont belong to object, It belongs to class directly. So, we cant do: $this->count
    // Use Cases of Staic Property and Method: Counter, Chache Value, to Make Singleton Pattern
    // See Example in DB Class

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
        self::$count++; // When we create a object, this static property will increment
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

    // Encapsulation:
    // We can set it as private and make getter setter if Need, But That Means the same thing as public, right?.
    // So geteters and setters don't always break the encapsulation.
    // As Amount is private, We can create a getter function to access it
    // But sometimes, getter and setter make sense like If we need to do something before accessing the property or before setting the property
    // With Setters, we can do method chaining
    // Dont Define Getter and Setter for Every Property Unless You actually Need Them
    public function getAmount(): float{
        return $this->amount;
    }

    // We can access private withing this Class Object
    public function copyFrom(Transaction $transaction){
        var_dump($transaction->amount);
    } // Now, we can access copyFrom() outside the class, so again private property is accessible

    // Encapsulation hides internal information, abstraction hides actual implementation
    // Abstraction: When You access class by object, you dont care what is happenning there. Implementation of method can't affect in accessing differntly

    // Setter for status
    public function setStatus(string $status): self{
        if(! isset(self::ALL_STATUS[$status])){
            throw new \InvalidArgumentException('Invalid Status');
        }
        $this->status = $status;
        return $this;
    }

    // Static Methods: When Method dont Depend on Object (Ex: Factory Pattern)
    // Accessing is same as static property
    // We can access static method non-statically ($object->getCount(), not recommended,make confusion)
    // If we use static in callback, we cant access $this. Ex- array_map(static function(){}, $array)
    // static methods have micro optimization over regular, but it's purpose should not be optimization. Use when you really need it, use when dont want to access $this in that method

    // Inheritence: Discussed in Toaster and ToasterPro Class

    // Abstract Class: Discussed in Field.php Class, Text.php

    // Interface and Polymorphism: Discussed in DebtCollector.php and CollectionAgency.php, DataCollectionService.php

    // Magic methods are special methods which override PHP's default action when certain actions are performed on an object
    // __construct(), __destruct(), __call(), __callStatic(), __get(), __set()
    // __isset(), __unset(), __sleep(), __wakeup(), __serialize(), __unseralize()
    // __toString(), __Invoke(), __set_state(), __clone(), __debuginfo()

    // Magic getter and setter:work automatically When property is private or protected. Wont work for public.
    public function __get(string $name){
        var_dump($name);
        // property_exists() - checking property
    }
    public function __set(string $name, $value): void{
        var_dump($name, $value);
    }
    public function __isset(string $name): bool{
        // Gets Called When You Use Isset or Empty Functions on Undefined, Empty Properties
        return array_key_exists($name, $this->data);
    }
    public function __unset(string $name): void{
        // Get Called When You use unset function on undefined or empty properties
    }
    public function __call(string $name, array $arguments){
        // It triggers when We call a undefined or unaccessible like protected method. Rather than showing error, this magic method will be called
        var_dump($name, $arguments);
        if(method_exists($this, $name)){
            call_user_func_array([$this, $name], $arguments);
        } // if method exists call that with arguments
    } // For static method- __callStatic()
    public function __toString(): string{
        return 'string';
        // When we print object directly (echo $object), hooked into it
        // $object instanceof Stringable - return true
        // When we use this magic method, we can add at class- implements Stringable (not requied, recommended)
    }
    public function __invoke(){
        // Gets triggeres when We try to call object Directly- $object()
        // Single Responsibility Classes can be defined Using it. Simple make Class invokable, and call directly $object()
    }
    public function __debugInfo(): ?array{
        // What should be printed when var_dup is used, like If we print password in var_dump, show hash
        return [
            'amount' => '**' . substr($this.amount, -3)
        ];
    }

    // Late Staic Binding: Early Binding Happens at Compile Time, Late Binding Happens at Runtime
    // Say we have class A and B which inherit A. If we have a method in class A, and we call that method from object of B, it will refer to Object B, not Object of A- This is Late Binding
    // But If we use static and self keyword, Calling from Object of B will refer to Class A that is early Binding, self not following proper inheritence rule here. Solution is Overriding in Child Class (Not Ideal)
    // If we replace self keyword by 'static' keyword, it will late static binding (solved). We can use it in normal function to call static property also

    // Traits: Common Functionality for Multiple Classes. If we import trais by 'use traitName', it will import trait in compile time
    // We cant use object of trait, just can use trait in another trait or in class
    // Trait simply copy the codes and paste it into the defined 
    // We can define same method where we are using
    // If same method name pesent in parent class and trait , then method of trait will be called
    // Conflic Resolution: If two traits have same methods (Ex. makeLatte) and we use it in class, it will throw error. But have solution:
    // use CappuccinoTrait, use LatteTrait { LatteTrait::makeLatte instadeof CappuccinoTrait }
    // or, using alias: use LatteTrait { LatteTrait::makeLatte as copyMakeLatte }
    // private method of trait can also be used where imported, but not from outside class. But We can change visibility:
    // use LatteTrait { LatteTrait::makeLatte as public; }
    // We can define properties in trait (visibility and type cant be override, same name with same value cant be redefined in class)
    // We can make abstract method in trait also
    // Static Properties and Methods in Trait
    // Trait should not be used except simple code

    // Annnymous Class: Also Discussed in index.php
    public function annonymous(): object{
        return new class($this->amount) extends Transaction {
            public function __construct(public int $amount){
                parent::__construct($amount);
                // We extends Transaction class so that We can use its property
            }
        };
    }
    // Main Use Case: Testing etc.

     // DockBlock:
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

     // Object Cloning
     // $object1 = clone $object2 (objects are differnt, but property value set others will be same)
     // If we need any clean up after any object clone, hook into __clone() magic method:
     public function __clone(): void{
        //....
     }

     // Serialization Related Magic Methods
     public function __sleep(): array{
        // Gets Called before the serialization happened
        return ['amount'];
        // when sleep seralize both used, seralize will work, same for deserialize
     }
     public function __wakeup(): void{
        // Gets Called after the object is unserialized
     }

     // Comination of Sleep, Wakeup and Serialization Interface
     public function __serialize(): array{
        // Just like sleep
        // sleep method must return names of the properties that to be seralized
        // serialize method must return an array that represents object, full control how your object is serialized
        return [
            'amount' => base64_encode($this->amount)
        ];
    }
    public function __unseralize(array $data): void{
        // Gets data as argument, extra advantage over wakeup
        $this->amount = base64_decode($data->amount);
    }

    // Iterator is discussed in TrnsactionCollection and index
    
    // Exception discussed in Customer Class and index
    
    // Destructor Magic Method
    // A destructor is called when the object is destructed or the script is stopped or exited.
    //  If you create a __destruct() function, PHP will automatically call this function at the end of the script. 
    public function __destruct(){
         echo "Destructor Calling";
         // It is used for clean up, database connection etc. Not Much Used
         // Ex: Closing Database Connection When Long Script
    }
}