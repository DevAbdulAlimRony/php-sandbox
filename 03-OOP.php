<?php
   //class- object [method, property]
   // Object-Oriented Programming (OOP) is a programming paradigm that uses objects, which are instances of classes, to structure and organize code. Object-Oriented Programming provides a structured, modular, and maintainable approach to software development. It promotes code reusability, abstraction, and encapsulation, making it an essential paradigm for building complex and maintainable software systems. 

   //A class is a blueprint or a template for creating objects. It defines the structure and behavior that objects created from the class will have.

   //A class defines attributes (also known as fields or properties) that represent the data or state that objects of the class will have. These attributes can have default values or be initialized in constructors.

   //A class also defines methods (also known as functions or behaviors) that specify the actions or operations that objects of the class can perform. 

   //: An object is an instance of a class. It is a concrete, individual entity created from a class blueprint. If a class is like a blueprint for houses, an object is a specific house built based on that blueprint.

   //Objects have values for the attributes defined in the class. Objects can invoke methods defined in the class. Classes specify what objects will look like and what they can do, while objects represent actual instances with specific data and behavior based on the class definition.

   class Human{
    public $name;
    private $age; //you can't set data for $age from outside of the class.
    protected $something; //If anyone inherit this class, they can use me.

    //a constructor method (often referred to simply as a "constructor") is a special method within a class that is automatically called when an object is created from that class. The constructor is used to initialize the object's attributes and perform any setup or initialization tasks required for the object to be in a valid state.
    function __construct($personName){
        $this->name = $personName;
    }
    function sayHi(){
        echo "Salam\n";
        $this->sayHi();
        echo "My name is {$this->name}";
    }
    //getter and setter function
    //get set magic method
    public function __get($prop){
        return $this->$prop;
    }
    public function __set($prop, $value){
        $this->$prop = $value;
    }
   }

   class Cat{
    public $name;
    function sayHi(){
        echo "Salam\n";
        $this->sayHi();
        echo "My name is {$this->name}";
    }

    function addSomething(Human $human){
        //We force that- the $human argument must be inherited from Human class or from Human Class
    }
   }

   $o1 = new Human('abdul'); //abdul is the argument from constructor
//If no constructor or has default value:    $o2 = new Human();
   $h1->name = "None"; //set data
   $h2->sayHi();

   //Object Cloning
   $h3 = clone $h2; //shallow copy

   //deep copy
   function __clone(){
    // $this->color = clone $this->color;
   }

   //Object to String Conversion
   function __toString(){}

   //Object Comparing
   $o1 == $o2; //If property values are same, then true
   $o1 === $o2; //similar if cloned, if not then not similar



   //Inheritance allows you to create new classes that inherit properties and behaviors (attributes and methods) from existing classes. This promotes code reuse, as you can define common characteristics in a base class and then create specialized classes that inherit those characteristics.
   class Baby extends Human {
    //now, we have all public and protected properties and method from Human Class
    //We can also override any method and add extra methods and properties here

    //Parent Child Class Scope: Suppose we are calling a method in constructor of parent class and defining same method in child class. If we call child class instance, then method of child class will be run

    //Calling Parent class' method
    function sayHi(){
        parent::sayHi();
    }
   }

   //Abstract classes can define method signatures (method names and parameters) without providing the actual method implementation. Subclasses must implement these abstract methods, ensuring that they adhere to a specific contract or interface. This enforces consistency in derived classes.
   abstract class SomeClass{ //You can extends/inherit me, but can't create my object
        function sayHi(){ echo "";}
        abstract function eat(); //I am forcing you to configure this function in child class

        //Now, we can't create object of this class but can use it as base class to inherit. We must configure the abstract function in our child class, rather that we will get an error. It is just an way that we can write code smartly.

        final function doSomething(){
            echo '';
        } //You can't override or configure this function in child class. We also can use this final keyword in normal class.
   }

   //Interfaces define a contract or a set of rules that classes implementing the interface must adhere to. This contract specifies the methods that must be implemented by any class that claims to implement the interface. It ensures that classes provide specific functionality, making code more predictable and reliable.
   //Interfaces and abstract classes are both used in object-oriented programming (OOP) to define contracts and structures for classes.  A class can implement multiple interfaces.  Interfaces define method signatures (method names, parameters, and return types) but do not provide any method implementations, but abstract class can do implementation. All methods declared in an interface are implicitly public and abstract. A class can inherit from only one abstract class.
   //Polymorphism allows objects of different classes to be treated as objects of a common base class or interface.
   interface BaseAnimal{
    public function isAlive();
    function canEat($p);
   }
   class Animal implements BaseAnimal{
    function isAlive(){}
    function canEat($p){}
   }
   interface BaseHuman extends BaseAnimal{}
   $cat = new Animal();
   echo $cat instanceof BaseAnimal;

   //Static Properties and Methods
   //Static methods are methods that belong to a class rather than an instance of the class. Static methods are often used to define utility functions or helper methods that are not tied to the state of any specific object but are relevant to the class as a whole. These methods can perform calculations, conversions, or other operations that are related to the class but don't require instance-specific data. Static methods can be called directly on the class itself without needing to create an instance of the class. 
   class MathCalc{
    //defining constant
    const A = '2.1'; // define() doesn't work 
    //$this::A, can get as static or by object
        static $name;
        protected static $age;

        static function fibonacci($n){
            self::$name = 12;
            echo "Something";
        }
        //To override in child, we must specify static keyword.
   }
   $m = new MathCalc();
   MathCalc::fibonacci(7); //don't need object

    //Early Binding and Late Binding: Description and Video: If in parent and child method name overrides, then self run first- that is early binding. if we use static:: rather than self, then method from child will be run. It is called late binding

    //Property Overloading - 
    //Property overloading in PHP refers to the ability to dynamically define and access object properties at runtime, even if those properties have not been explicitly declared within the class. This feature is achieved through two magic methods: __get() and __set(). 
    //__isset(), __unset() - checking if property exists in the class

    //Method Overloading: Method is not present in class, but we don't get any error if we access it
    function __call(){}
    function __callStatic(){}

    //Auto Loading- Video

    //Namespace- Last two videos

    //Method Chaining- Method chaining in PHP is a coding technique that allows you to call multiple methods on an object in a single line of code by chaining the method calls together,  each method in the chain typically returns the object itself (i.e., $this) after performing its operations. This allows you to immediately call another method on the same object without having to store the object in a separate variable after each method call.

    //Dependency Injection/IOC-Inverse of Control
    class StudentManager{
        function in($name){
            $st = new SomeClass(); 
            //It is hard dependency. we can modify it-
            //Tightly Coupled
        }
    }

    class StudentManager2{
        function in($student){
            $student->methodFromDependentClass();
        }
    }
    $st = new SomeClass();
    // $sm = new Human();
    // $st->methodFromDependentClass($sm); - We pass the object rather than property, dependency injection
    //Loosely Coupled when we use dependency injection
    //or, method(Human $human)
    //Dependency Injection (DI) is a design pattern and a technique used in object-oriented programming (OOP) and software development to manage and provide the dependencies (i.e., objects or services) that a class or component relies on. Instead of creating or managing its dependencies internally, a class receives them from an external source, typically through constructor parameters or method arguments.

    //The main goals of dependency injection are to promote code reusability, improve testability, reduce coupling between components, and enhance maintainability.

    //Date Time Using OOP
    $d1 = new DateTime();
    //date_diff(), format()

    //Exception: throw new exception,try catch finally

    //Trait: a trait is a code reuse mechanism that allows you to define a set of methods that can be used in multiple classes independently of class inheritance. Class can include traits as many as once and a trait can also use another trait. We can use trait, but can not intanstiate it or create object of it
    trait numberOne{
        //...some methods
        //We can also use static and abstract method and property  here
    }
    trait numberTwo{ 
        use NumberOne;
        //..some methods
    }
    class Something{
        use NumberOne, NumberTwo;
        //We can override any method from trait in the class, but it won't work if it inherited.

        //We can create alias for method name if we want to access method as different name.
        // use numberThree{
        //     NumberThree::methodNameOld as methodNameNew; 
        // }
    }

    //Solid Principle: Collection of 5 principles/rules
        //1. Single Responsibility Principle: One class should do just one particular task, not multiple task.
        class Student{
            function checkAttendencae(){}
            function calculateGrade(){}
            function collectFee(){}
            //Rather than, define different class for those different task
        }
        class BetterMailer{
            // function __construct(MailGatewayInterface $mg, MailInterface $mail, AttachmentInterface $attachment){
             //rather than define those as methods in a single class, we took different interface for different task and inject them
            // }
        }

        //2. Open Close Principle: OPen for extension, close for modification. Write code in that way- when you finish writing class and later, you need to modify something into that class- you won't need to write extra code in that class. Ex. Dependency Injection from another class, but not modify the closed class
        class FileDisplay{
            function display($file, $fileType){
                if('mp4' == $fileType){}
                //If we need to check another type, we need to write extra code
            }
        }
        //We can rewrite this class according to the open close principle like that:
        class FileDisplay2{
            function Display(FileInterface $file){
                $file->display();
            }
        }
        interface FileInterface{
            function display();
        }
        class ImgFile implements FileInterface{
            function display(){}
        } //Now we can create other child classes like videoFile as we need.

        //3. Liskov Substitution Principle: Barbara Liskov, a software engineer suggested it. If a object can do a task, then the subclass of that object should perform that task also. If I pass an object as parameter, I can also pass the sub classes of that object as parameter.
        //video for better understanding.  

        //4. Interface Segregation Principle: Rather than writing a monolithic interface, we should use multiple interface per functionality. 

        //5. Dependency Inversion Principle: If a class depends on another class, then that another class should be abstract.

//Design Pattern
//Singleton Pattern: One class shouldn't be instantiated again again,rather than should have one object.
class Singleton{
    static $instance;
    static function getInstance(){
        if(!self::$instance){
            self::$instance = new Singleton();
        }
        else{}
        return self::$instance;
    }
}
$object1 = Singleton::getInstance();

    //Problem: always get same argument because of that same object. If our class is parameterized, then we have to handle it differently. $instance can be defined as array.

//Adapter Pattern: If two classes can't fit with each other, we can use something between them like an adapter(ex. three pin)
//Decorator Pattern
//Factory Pattern
//Abstract Factory Pattern

//Facade Pattern: 
class SpaceShuttle{
    function PowerOn(){}
    function checkTemp(){}
    //More Method..If we do this, we have to call all method to use them. Facade Pattern solve that problem:-
}
class SpaceShuttleFacade{
    private $shuttle;
    function __construct(SpaceShuttle $shuttle){
        $this->shuttle = $shuttle;
    }
    function takeoff(){
        $this->shuttle->powerOn();
        $this->shuttle->checkTemp();
    }
}
$ss = new SpaceShuttle();
$ssf = new SpaceShuttleFacade($ss);
$ssf->takeoff(); //don't need to call all method one after another.

//Strategy Pattern


//How we use in laravel from here- everything idea and observe laravel's code (like one facade code)

//Namespace: Namespace is a concept of oop to group our classes properly. namespaces are used to organize and encapsulate code into logical groups, preventing naming conflicts and providing better code organization and maintainability.  Advantages- Avoiding naming Conflicts,Logically organized Code, Improved AutoLoading, global namespace safety, versioning and maintenance etc.

?>