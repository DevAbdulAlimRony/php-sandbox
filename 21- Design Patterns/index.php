<?php
// Design patterns are typical solutions to commonly occurring problems in software design.  
// The pattern is not a specific piece of code, but a general concept for solving a particular problem 
// Design patterns define a common language that you and your teammates can use to communicate more efficiently. 
// Design patterns differ by their complexity, level of detail and scale of applicability to the entire system being designedSome groups of patterns: Creational Patter, Structural Pattern, Behavioral Pattern. -->

// **Creational Design Patterns:
// Creational design patterns provide various object creation mechanisms, which increase flexibility and reuse of existing code. 
// Types: Factory Method, Abstract Factory, Builder, Prototype, Singleton -->
// **Factory Method:
// Factory Method is a creational design pattern that provides an interface for creating objects in a superclass, but allows subclasses to alter the type of objects that will be created. 
// Ex1: Application needs to send notifications, Desktop app send system notification, mobile app send push notification, in app showing ui notification and so on. 
// If you didn't use the Factory Method, your notify function would likely look like this:
class oldNotification{
    public function notify(string $type, string $message): void
    {
        // 1. Logic is hardcoded: Every time you add a new type (Slack, WhatsApp), 
        // you MUST change this base class. This violates the Open/Closed Principle.
        // The base class becomes dependent on every single concrete implementation.
        // You can't easily swap notification behaviors at runtime based on the environment.
        if ($type === 'desktop') {
            $notification = new DesktopNotification();
        } elseif ($type === 'mobile') {
            $notification = new MobileNotification();
        }
    
        $notification->send($message);
    }
}

// Using Factory Method pattern:
// Step1- Create a interface for Product
interface Notification
{
    public function send(string $message): void;
}

// Step2- Create Concrete Product classes implementing the Product interface.
class DesktopNotification implements Notification {
    public function send(string $message): void {
        echo "[Desktop] Showing system tray alert: $message\n";
    }
}
class MobileNotification implements Notification {
    public function send(string $message): void {
        echo "[Mobile] Sending Push Notification via Firebase: $message\n";
    }
}

// Step3- Create Creator abstract class with Factory Method that returns Product interface type.
abstract class NotificationSender
{
    // Factory Method (Must Return a interface's Object)
    abstract protected function createNotification(): Notification;

    public function notify(string $message): void
    {
        $notification = $this->createNotification();
        $notification->send($message);
    }
}

// Step4- Create Concrete Creator classes that override the Factory Method to return Concrete Product instances.
class DesktopNotificationSender extends NotificationSender
{
    protected function createNotification(): Notification
    {
        return new DesktopNotification();
    }
}
class MobileNotificationSender extends NotificationSender
{
    protected function createNotification(): Notification
    {
        return new MobileNotification();
    }
}

// --- CLIENT CODE ---
function clientCode(NotificationSender $sender) {
    $sender->notify("Hello! You have a new message.");
}

// The client doesn't need to know if it's mobile or desktop.
echo "App running on Windows:\n";
clientCode(new DesktopNotificationSender());

echo "\nApp running on Android:\n";
clientCode(new MobileNotificationSender());

// Pros: Solve problem for single responsibility class and open and closed principle
// Cons: So many subclasses.

// More Examples:
// Logistics Systems: A transport application uses a factory to return a Truck object for land routes and a Ship object for sea routes.
// Document Editors: A universal "New Document" command triggers a factory that returns a .docx object in a Word processor or a .sheet object in a spreadsheet app.
// Database Connectors: A database manager provides a factory method that returns a MySQL connection, a PostgreSQL connection, or an Oracle connection based on the configuration.
// Payment Processing: An e-commerce backend uses a factory to generate the correct payment gateway object, such as Stripe, PayPal, or ApplePay, based on user selection.
// File Converters: A media application uses a factory to create the appropriate encoder object (e.g., MP4Encoder or AVIEncoder) depending on the desired output format.
// Social Media Auth: A login handler uses a factory to produce different authentication providers like GoogleAuth, FacebookAuth, or GithubAuth.
// Report Generators: A reporting tool employs a factory method to return a PDFReport, HTMLReport, or CSVReport generator based on the user's export choice.
// Theme Management: A website engine uses a factory to create UI components that match either a DarkTheme or a LightTheme style.
// Cloud Infrastructure: A cloud manager uses a factory method to provision resources, returning an AWSInstance, AzureVM, or GoogleCloudNode depending on the provider.
// Logging Libraries: A logger interface defines a method to create an appender, allowing subclasses to output logs to a FileLog, ConsoleLog, or DatabaseLog.
// Insurance Portals: A policy generator uses a factory to return specific policy types like LifeInsurance, AutoInsurance, or HomeInsurance based on the user's application
// Health Trackers: A fitness app uses a factory to create activity trackers for different sports, such as a RunningTracker, CyclingTracker, or SwimmingTracker. etc.

// **Abstract Factory:
// Abstract Factory is a creational design pattern that lets you produce families of related objects without specifying their concrete classes.
// Ex- In a furniture shop, a family of related products Chair + Sofa + CoffeeTable are available in these variants: Modern, Victorian, ArtDeco.
// You need a way to create individual furniture objects so that they match other objects of the same family.
// Also, you don’t want to change existing code when adding new products or families of products to the program.
// Step1- Interfaces for eah distict product, make all variants of product following the interfaces, Step3: create  abstract factory(FurnitureFactory, ModernFurnitureFactory etc.) which can include createChair, createSofa etc- Must return abstract product types of interfaces.
// Use the Abstract Factory when your code needs to work with various families of related products, but you don’t want it to depend on the concrete classes of those products
// Real life Example: Multiple Database Connections.
interface FurnitureFactory
{
    public function createChair(): Chair;
    public function createSofa(): Sofa;
    public function createCoffeeTable(): CoffeeTable;
}

class ModernFurnitureFactory implements FurnitureFactory
{
    public function createChair(): Chair
    {
        return new ModernChair();
    }

    public function createSofa(): Sofa
    {
        return new ModernSofa();
    }

    public function createCoffeeTable(): CoffeeTable
    {
        return new ModernCoffeeTable();
    }
} // This way, VictorianFurnitureFactory and if others.
interface Chair
{
    public function sitOn(): string;
}

interface Sofa
{
    public function lieOn(): string;
}

interface CoffeeTable
{
    public function putCoffee(): string;
}
class ModernChair implements Chair
{
    public function sitOn(): string
    {
        return "You are sitting on a Modern Chair with clean lines.";
    }
}
class ModernSofa implements Sofa
{
    public function lieOn(): string
    {
        return "You are lying on a Modern Sofa with minimalist design.";
    }
}

class ModernCoffeeTable implements CoffeeTable
{
    public function putCoffee(): string
    {
        return "Coffee placed on a Modern Coffee Table made of glass and steel.";
    }
}

function furnishRoom(FurnitureFactory $factory): void
{
    $chair = $factory->createChair();
    $sofa = $factory->createSofa();
    $table = $factory->createCoffeeTable();

    echo $chair->sitOn() . PHP_EOL;
    echo $sofa->lieOn() . PHP_EOL;
    echo $table->putCoffee() . PHP_EOL;
}
$furnitureFactory = new ModernFurnitureFactory();
furnishRoom($furnitureFactory);

// You need the Abstract Factory when your system needs to stay consistent across multiple types of products, and you want to ensure that products from "Family A" are never mixed with products from "Family B."


// **Builder Pattern:
// Builder is a creational design pattern that lets you construct complex objects step by step.
// The pattern allows you to produce different types and representations of an object using the same construction code.
// Imagine we have a House class which have many features. Maybe we can make subclasses but it will have so many subclasses. Or we can inject all objects into constructor, that will be complex also and not perfromant if the object is useless.
// The Builder pattern suggests that you extract the object construction code out of its own class and move it to separate objects called builders.
// The Builder doesn’t allow other objects to access the product while it’s being built.
// Laravel's Query Builder is a real-world example of the Builder pattern.

// If we create multiple constructors for each attribute, it will lead to a large number of constructor parameters. This is known as the telescoping constructor anti-pattern.
/**
 * ============================================================
 * 1) THE PROBLEM (WITHOUT BUILDER)
 * ============================================================
 * When a class has MANY fields, a normal constructor becomes:
 * - too long
 * - hard to read (easy to mix parameter order)
 * - hard to maintain (adding 1 new field changes every "new Product(...)" call)
 * - hard to handle optional fields (you end up passing null/empty values)
 */
class Product
{
    public int $id;
    public string $name;
    public int $price;
    public string $description;
    public string $manufacturer;
    public string $inventory;
    public int $discount;

    public function __construct(
      int $id,
      string $name,
      int $price,
      string $description,
      string $manufacturer,
      string $inventory,
      int $discount
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->manufacturer = $manufacturer;
        $this->inventory = $inventory;
        $this->discount = $discount;
    }
}
$badProduct = new Product(
    101,
    'iPhone 13',
    999.99,
    'New iPhone 13 with A15 Bionic chip',
    'Apple Inc.',
    10,     // <-- should be inventory, but accidentally put discount
    1000    // <-- should be discount, but accidentally put inventory
);

/**
 * ============================================================
 * 2) THE SOLUTION (WITH BUILDER)
 * ============================================================
 * Builder creates the object step-by-step, using clear method names.
 * It solves:
 * - readability (setName, setPrice...)
 * - avoids parameter-order bugs
 * - allows optional fields naturally (set only what you have)
 * - easier maintenance: adding a new field usually changes only Builder + Product2
 */
class Product2
{
    // private properties (better encapsulation than public fields)
    private $id;
    private $name;
    private $price;
    private $description;
    private $manufacturer;
    private $inventory;
    private $discount;

     /**
     * Product2 constructor accepts a builder.
     * This forces object creation to go through ProductBuilder.
     */
    public function __construct(ProductBuilder $builder)
    {
        $this->id = $builder->getId();
        $this->name = $builder->getName();
        $this->price = $builder->getPrice();
        $this->description = $builder->getDescription();
        $this->manufacturer = $builder->getManufacturer();
        $this->inventory = $builder->getInventory();
        $this->discount = $builder->getDiscount();
    }

    // getters (read-only object)
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getPrice(): float { return $this->price; }
    public function getDescription(): string { return $this->description; }
    public function getManufacturer(): string { return $this->manufacturer; }
    public function getInventory(): int { return $this->inventory; }
    public function getDiscount(): int { return $this->discount; }

    // Example business method (optional): final price after discount
    public function finalPrice(): float
    {
        $discountAmount = $this->price * ($this->discount / 100);
        return $this->price - $discountAmount;
    }
}

/**
 * ProductBuilder
 * - stores values step-by-step
 * - can validate required fields
 * - returns $this for fluent chaining
 */
class ProductBuilder
{
    private ?int $id = null;
    private ?string $name = null;
    private ?float $price = null;
    private ?string $description = null;
    private ?string $manufacturer = null;
    private ?int $inventory = null;
    private ?int $discount = null;

    // Fluent setters (each returns $this)
    public function setId(int $id): self
    {
        // you can validate here
        if ($id <= 0) {
            throw new InvalidArgumentException("Product id must be positive.");
        }
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): self
    {
        $name = trim($name);
        if ($name === '') {
            throw new InvalidArgumentException("Product name can't be empty.");
        }
        $this->name = $name;
        return $this;
    }

    public function setPrice(float $price): self
    {
        if ($price < 0) {
            throw new InvalidArgumentException("Price can't be negative.");
        }
        $this->price = $price;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = trim($description);
        return $this;
    }

    public function setManufacturer(string $manufacturer): self
    {
        $manufacturer = trim($manufacturer);
        if ($manufacturer === '') {
            throw new InvalidArgumentException("Manufacturer can't be empty.");
        }
        $this->manufacturer = $manufacturer;
        return $this;
    }

    public function setInventory(int $inventory): self
    {
        if ($inventory < 0) {
            throw new InvalidArgumentException("Inventory can't be negative.");
        }
        $this->inventory = $inventory;
        return $this;
    }

    public function setDiscount(int $discount): self
    {
        if ($discount < 0 || $discount > 100) {
            throw new InvalidArgumentException("Discount must be 0..100.");
        }
        $this->discount = $discount;
        return $this;
    }

    /**
     * --------------------------
     * Getters used by Product2
     * --------------------------
     * Here we also enforce "required fields" before building.
     */
    public function getId(): int
    {
        return $this->require($this->id, 'id');
    }

    public function getName(): string
    {
        return $this->require($this->name, 'name');
    }

    public function getPrice(): float
    {
        return $this->require($this->price, 'price');
    }

    public function getDescription(): string
    {
        // Optional example: if not set, default to empty
        return $this->description ?? '';
    }

    public function getManufacturer(): string
    {
        return $this->require($this->manufacturer, 'manufacturer');
    }

    public function getInventory(): int
    {
        // Optional example: default 0 if not set
        return $this->inventory ?? 0;
    }

    public function getDiscount(): int
    {
        // Optional example: default 0 if not set
        return $this->discount ?? 0;
    }

    /**
     * Build the final Product2 object.
     * - validates required fields
     * - returns a ready-to-use product
     */
    public function build(): Product2
    {
        // Ensure required fields exist BEFORE product creation
        $this->getId();
        $this->getName();
        $this->getPrice();
        $this->getManufacturer();

        return new Product2($this);
    }

    /**
     * Helper for required fields
     */
    private function require(mixed $value, string $fieldName): mixed
    {
        if ($value === null) {
            throw new RuntimeException("Missing required field: {$fieldName}");
        }
        return $value;
    }
}
$productBuilder = new ProductBuilder();
$product = $productBuilder
                ->setId(101)
                ->setName('iPhone 13')
                ->setPrice(999.99)
                ->setDescription('New iPhone 13 with A15 Bionic chip')
                ->setManufacturer('Apple Inc.')
                ->setInventory(1000)
                ->setDiscount(10)
                ->build();
echo "Product created: {$product->getName()} with final price: {$product->finalPrice()}\n";

// More Examples:
// Query Builders: Constructing a complex SQL query with multiple WHERE, JOIN, and ORDER BY clauses step-by-step.
// Meal Ordering System: Creating a "Burger" object where a user can optionally add extra cheese, remove onions, or choose a specific patty type.
// Report Generators: Creating an Excel report where you define columns, add filters, and apply styling before finally "exporting" it.
// Character Creators (Games): Building a player character by selecting hair style, armor type, weapon, and skill points.


// **Prototype Pattern:
// Prototype is a creational design pattern that lets you copy existing objects without making your code dependent
// Say you have an object, and you want to create an exact copy of it. How would you do it? First, you have to create a new object of the same class. Then you have to go through all the fields of the original object and copy their values over to the new object.
// Copying an object “from the outside” isn’t always possible. Sometimes, the class of the object may not even be known beforehand. Even if you do know the class, it may not expose all the data you need to copy.
// There’s one more problem with the direct approach. Since you have to know the object’s class to create a duplicate, your code becomes dependent on that class. 
// The Prototype pattern suggests that you clone objects via a special method defined in the object’s class. The pattern declares a common interface for all objects that support cloning.
// Usually, such an interface contains just a single clone method.
// An object that supports cloning is called a prototype.
// When your objects have dozens of fields and hundreds of possible configurations, cloning them might serve as an alternative to subclassing.
// Real life Example: Enemy Spawning in Game Development, Copy Paste Functionality in Graphics Editor, Database Configuration Cache.  
// Ex- How to clone a complex Page object using the Prototype pattern. The Page class has lots of private fields, which will be carried over to the cloned object thanks to the Prototype pattern.
class Page
{
    private $title;

    private $body;

    private $author;

    private $comments = [];

    /**
     * @var \DateTime
     */
    private $date;

    // +100 private fields.

    public function __construct(string $title, string $body, Author $author)
    {
        $this->title = $title;
        $this->body = $body;
        $this->author = $author;
        $this->author->addToPage($this);
        $this->date = new \DateTime();
    }

    public function addComment(string $comment): void
    {
        $this->comments[] = $comment;
    }

    /**
     * You can control what data you want to carry over to the cloned object.
     *
     * For instance, when a page is cloned:
     * - It gets a new "Copy of ..." title.
     * - The author of the page remains the same. Therefore we leave the
     * reference to the existing object while adding the cloned page to the list
     * of the author's pages.
     * - We don't carry over the comments from the old page.
     * - We also attach a new date object to the page.
     */
    public function __clone()
    {
        $this->title = "Copy of " . $this->title;
        $this->author->addToPage($this);
        $this->comments = [];
        $this->date = new \DateTime();
    }
}

class Author
{
    private $name;

    /**
     * @var Page[]
     */
    private $pages = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addToPage(Page $page): void
    {
        $this->pages[] = $page;
    }
}

function clientCode2()
{
    $author = new Author("John Smith");
    $page   = new Page("Tip of the day", "Keep calm and carry on.", $author);

    // ...

    $page->addComment("Nice tip, thanks!");

    // ...

    $draft = clone $page;
    echo "Dump of the clone. Note that the author is now referencing two objects.\n\n";
    print_r($draft);
}

// Laravel uses prototype design pattern for model. If you need 30 model, laravel have just one instance and its replicate() method.
// Laravel’s Service Container (the heart of the framework) uses a variation of the Prototype pattern when handling Singletons.

// **Singleton Pattern:
// Singleton is a creational design pattern that lets you ensure that a class has only one instance.
// It ensures a class has just a single instance, Imagine that you created an object, but after a while decided to create a new one. Instead of receiving a fresh object, you’ll get the one you already created.
// This behavior is impossible to implement with a regular constructor since a constructor call must always return a new object by design.
// Steps: Make the default constructor private, to prevent other objects from using the new operator with the Singleton class, Create a static creation method that acts as a constructor. Under the hood, this method calls the private constructor to create an object and saves.
// Disadvantages: Violates the single responsibility principle because it solves two problems at a time, it can mask bad design, difficult to unit test.
// Real life Example:  Database Connection Pool, Logging Service- provide a global logging object, Configuration Manager- shared runtime configuration object etc.
class Logger
{
    // Hold the single instance of the class
    private static $instance = null;
    private $logFile;

    // 1. PRIVATE CONSTRUCTOR: Prevents 'new Logger()' from outside
    private function __construct()
    {
        $this->logFile = "app_log.txt";
        echo "--- File '{$this->logFile}' opened for writing. ---\n";
    }

    // 2. THE GATEKEEPER: Static method to get the instance
    public static function getInstance()
    {
        if (self::$instance == null) {
            // Only create it if it doesn't exist yet
            self::$instance = new Logger();
        }
        return self::$instance;
    }

    // 3. Prevent Cloning (Singleton must be unique)
    private function __clone() {}

    public function log(string $message)
    {
        echo "Writing to log: $message\n";
        // file_put_contents($this->logFile, $message, FILE_APPEND);
    }
}

// --- Client Code ---

// $log = new Logger(); // ERROR: Call to private constructor

$logger1 = Logger::getInstance();
$logger1->log("User 'Admin' logged in.");

$logger2 = Logger::getInstance();
$logger2->log("Database query executed.");

// Proof that they are the same instance
if ($logger1 === $logger2) {
    echo "\nSUCCESS: Both loggers are the EXACT same instance in memory.";
}

// Laravel uses this pattern for:
// When your website loads, Laravel creates one single instance of the Illuminate\Foundation\Application class. $app, service container etc.

// Imagine you are checking the logged-in user in your navigation bar, then again in a sidebar, and finally in a controller to check permissions.
// The Problem without Singleton: Each check would require a new "Auth" object, potentially re-querying the database or re-parsing the session data three different times.
// The Singleton Solution: Laravel binds the Auth manager as a singleton. $user = auth()->user(); // First call creates the Auth instance
// @if(Auth::check()) // Second call returns the SAME Auth instance.
// aravel prefers the Container over "Static" Singletons for testability and 
// Decoupling- our code doesn't need to know it's a Singleton. It just asks for a class, and Laravel decides whether to provide a new one or a shared one.
