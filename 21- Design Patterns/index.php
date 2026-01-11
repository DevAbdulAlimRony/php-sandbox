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

// **Structural Design Patterns:
// Structural design patterns explain how to assemble objects and classes into larger structures, while keeping these structures flexible and efficient.
// **Adapter/Wrapper Pattern: Adapter is a structural design pattern that allows objects with incompatible interfaces to collaborate.
// Let's say one object returning data into xml format, but in future I need json also.
// Create Adapter, An adapter a special object that converts the interface of one object so that another object can understand it.
// Adapters can not only convert data into various formats but can also help objects with different interfaces collaborate.
// Sometimes it’s even possible to create a two-way adapter that can convert the calls in both directions.
// Objecct Adapter: This implementation uses the object composition principle: the adapter implements the interface of one object and wraps the other one. 
// Class Adapter: This implementation uses inheritance: the adapter inherits interfaces from both objects at the same time. 
// Use the Adapter class when you want to use some existing class, but its interface isn’t compatible with the rest of your code.
// The Adapter pattern lets you create a middle-layer class that serves as a translator between your code and a legacy class, a 3rd-party class or any other class with a weird interface.
// Examples:
// Media Players: An app expects an AudioPlayer interface, but you need to integrate a library that only plays .vlc or .mp4 files using different method names.
// Data Serialization: Your UI expects data in JSON format, but an old legacy API returns XML. The adapter converts the XML response into a JSON object.
// Logging Frameworks: Your application uses a standard Logger interface, but you want to use a specific third-party tool like Log4j or Serilog which has different method signatures (e.g., log_message() vs write_to_stream()).
// Database Drivers: Most ORMs (Object Relational Mappers) use adapters to talk to different databases (MySQL, PostgreSQL, Oracle) using the same set of commands.
// Laravel uses for filesystem- Laravel’s Storage facade provides a unified interface (e.g., put(), get(), exists()) regardless of whether you are saving files to your Local disk, Amazon S3, or SFTP.
// When you send an email in Laravel using Mail::send(), the framework doesn't care if you're using SMTP, Mailgun, Postmark, or Amazon SES.
// In PHP, the Object-Based Adapter is the industry standard. This is because PHP does not support multiple inheritance, making the Class-Based Adapter (which requires inheriting from two classes at once) impossible for two concrete classes.
// Example: You have existing code that expects one interface (your app’s NotifierInterface), but you want to use third-party services (Twilio, Firebase, Mailgun, etc.) that each have different method names + payload formats.
// Without Adapter → your code becomes full of if/else / switch on provider type, and every time you add a new provider you must edit many places.
// Your app wants to call $notifier->send($to, $message);, but now for different twillo: messages->create($to, ['body' => $text]), firebase: sendToToken($token, $payload) etc.
// Adapter lets you keep one common interface in the app, plug in any provider via a small translator or adapter class, add new providers without changing the main business code.
/**
 * Target interface: your application code only knows this.
 * It doesn't care which vendor (Twilio/Firebase/etc.) is used.
 */
interface NotifierInterface
{
    public function send(string $to, string $message): void;
}
/**
 * 3rd-party SMS SDK (example).
 * Notice: it doesn't match NotifierInterface at all.
 */
class TwilioSmsClient
{
    public function sendSms(string $phone, array $data): void
    {
        // Imagine: actual Twilio SDK call here
        // $this->client->messages->create($phone, ['body' => $data['body']]);
        echo "Twilio SMS to {$phone}: {$data['body']}\n";
    }
}
/**
 * 3rd-party Push SDK (example).
 * Different method name + payload format.
 */
class FirebasePushClient
{
    public function sendToToken(string $token, array $payload): void
    {
        // Imagine: actual Firebase call here
        echo "Firebase Push to {$token}: {$payload['title']} - {$payload['body']}\n";
    }
}
/**
 * Adapter for Twilio.
 * Converts send($to,$message) into Twilio's sendSms($phone,$data).
 */
class TwilioSmsNotifierAdapter implements NotifierInterface
{
    public function __construct(private TwilioSmsClient $twilio) {}

    public function send(string $to, string $message): void
    {
        // Translate to Twilio's expected payload format
        $this->twilio->sendSms($to, ['body' => $message]);
    }
}

/**
 * Adapter for Firebase.
 * Converts send($to,$message) into Firebase's sendToToken($token,$payload).
 */
class FirebasePushNotifierAdapter implements NotifierInterface
{
    public function __construct(private FirebasePushClient $firebase) {}

    public function send(string $to, string $message): void
    {
        // Translate to Firebase's expected payload format
        $payload = [
            'title' => 'Notification',
            'body'  => $message,
        ];

        $this->firebase->sendToToken($to, $payload);
    }
}

/**
 * Your application service.
 * This code never changes when you add a new provider.
 */
class OrderService
{
    public function __construct(private NotifierInterface $notifier) {}

    public function placeOrder(string $userContact): void
    {
        // ... order logic ...
        $this->notifier->send($userContact, "Your order has been placed successfully!");
    }
}

// Use SMS (Twilio)
$twilio = new TwilioSmsClient();
$smsNotifier = new TwilioSmsNotifierAdapter($twilio);

$orderService = new OrderService($smsNotifier);
$orderService->placeOrder('+8801712345678');

// Switch to Push (Firebase) without changing OrderService
$firebase = new FirebasePushClient();
$pushNotifier = new FirebasePushNotifierAdapter($firebase);

$orderService2 = new OrderService($pushNotifier);
$orderService2->placeOrder('firebase_device_token_abc');


// **Bridge Pattern: Bridge is a structural design pattern that lets you split a large class or a set of closely related classes into two separate hierarchies—abstraction and implementation—which can be developed independently of each other.
// Examples: You have shape classes (Circle, Square, etc.) and you have different color methods (Red, Blue, Green).
// or, You have to send error log in Slackand Whatsapp, You have to send Info Log and Error Type Log.
// Instead of creating subclasses for each combination (RedCircle, BlueCircle, RedSquare, BlueSquare, etc.), you can use the Bridge pattern to separate the shape hierarchy from the color hierarchy.
// This way, you can mix and match shapes and colors without creating a new subclass for each
// Imagine you want to post messages to different platforms (Facebook, Twitter) using different styles of posts (Simple Post, Scheduled Post).
interface SocialNetworkImplementation {
    public function login();
    public function sendPost($message);
    public function logout();
}
class FacebookApi implements SocialNetworkImplementation {
    public function login() { echo "Logged into Facebook.\n"; }
    public function sendPost($message) { echo "Facebook: Posting -> $message\n"; }
    public function logout() { echo "Logged out of Facebook.\n"; }
}

class TwitterApi implements SocialNetworkImplementation {
    public function login() { echo "Logged into Twitter.\n"; }
    public function sendPost($message) { echo "Twitter: Tweeting -> $message\n"; }
    public function logout() { echo "Logged out of Twitter.\n"; }
}
// This is the "high-level" control layer that holds a reference to the implementation.
abstract class PostContent {
    protected $platform;

    public function __construct(SocialNetworkImplementation $platform) {
        $this->platform = $platform;
    }

    abstract public function post($message);
}
class SimplePost extends PostContent {
    public function post($message) {
        $this->platform->login();
        $this->platform->sendPost($message);
        $this->platform->logout();
    }
}

class UrgentPost extends PostContent {
    public function post($message) {
        $this->platform->login();
        $this->platform->sendPost("URGENT: " . $message);
        $this->platform->logout();
    }
}
// Post a simple message to Facebook
$facebookPost = new SimplePost(new FacebookApi());
$facebookPost->post("Hello World!");

echo "---\n";

// Post an urgent message to Twitter
$twitterPost = new UrgentPost(new TwitterApi());
$twitterPost->post("The server is down!");
// The Bridge pattern is best when you have two independent dimensions of growth.

// Example2: Imagine you have different Checkout Types (Standard, Subscription, One-Click) and different Payment Gateways (Stripe, PayPal, Razorpay).
// Combining bridge and factory pattern:
interface PaymentGateway {
    public function authenticate();
    public function executePayment($amount);
}

class StripeGateway implements PaymentGateway {
    public function authenticate() { return "Stripe API Key Validated."; }
    public function executePayment($amount) { return "Stripe: Charged $$amount"; }
}

class PayPalGateway implements PaymentGateway {
    public function authenticate() { return "PayPal OAuth Token Validated."; }
    public function executePayment($amount) { return "PayPal: Charged $$amount"; }
}
abstract class CheckoutProcess {
    protected $gateway;

    public function __construct(PaymentGateway $gateway) {
        $this->gateway = $gateway;
    }

    abstract public function finalize($amount);
}
class StandardCheckout extends CheckoutProcess {
    public function finalize($amount) {
        echo $this->gateway->authenticate() . "\n";
        echo "Processing standard checkout...\n";
        echo $this->gateway->executePayment($amount) . "\n";
    }
}

class SubscriptionCheckout extends CheckoutProcess {
    public function finalize($amount) {
        echo $this->gateway->authenticate() . "\n";
        echo "Setting up recurring billing for $$amount...\n";
        echo $this->gateway->executePayment($amount) . "\n";
        echo "Subscription record created in database.\n";
    }
}
class PaymentGatewayFactory {
    public static function make(string $type): PaymentGateway {
        return match($type) {
            'stripe' => new StripeGateway(),
            'paypal' => new PayPalGateway(),
            default => throw new Exception("Gateway not supported"),
        };
    }
}
class CheckoutFactory {
    public static function make(string $type, PaymentGateway $gateway): CheckoutProcess {
        return match($type) {
            'standard'     => new StandardCheckout($gateway),
            'subscription' => new SubscriptionCheckout($gateway),
            default        => throw new Exception("Checkout type [$type] unknown."),
        };
    }
}
class PaymentService {
    public function handle(string $method, string $type, float $amount) {
        // 1. Resolve the implementation (Gateway)
        $gateway = PaymentGatewayFactory::make($method);

        // 2. Resolve the abstraction (Checkout Type) and Bridge it
        $checkout = CheckoutFactory::make($type, $gateway);

        // 3. Execute
        return $checkout->finalize($amount);
    }
}
class PaymentController extends Controller {
    public function __construct(protected PaymentService $paymentService) {}

    public function store(Request $request) {
        // High-level intent only
        $this->paymentService->handle(
            $request->payment_method, // e.g., 'stripe'
            $request->checkout_type,   // e.g., 'subscription'
            $request->amount
        );

        // return response()->json(['message' => 'Payment processed successfully']);
    }
}
// Now, subscription can be monthly or yearly or lifetime etc.
// So, we can make new bridges.

// **Composite/ObjectTree Pattern:
// Composite is a structural design pattern that lets you compose objects into tree structures and then work with these structures as if they were individual objects.
// Using the Composite pattern makes sense only when the core model of your app can be represented as a tree.
// For example, imagine that you have two types of objects: Products and Boxes. A Box can contain several Products as well as a number of smaller Boxes. These little Boxes can also hold some Products or even smaller Boxes, and so on.
// The Composite pattern suggests that you work with Products and Boxes through a common interface which declares a method for calculating the total price.
// Examples: Organization Hierarchy: An "Employee" is a leaf; a "Department" is a composite containing employees and sub-departments.
// Menu Systems: A "Menu Item" (link) is a leaf; a "Menu Category" (dropdown) is a composite containing links and other sub-menus.
/**
 * Composite Design Pattern (Real-life example):
 * ------------------------------------------------------------
 * Use-case: Company org chart / team structure
 *
 * - Leaf: Employee (cannot contain children)
 * - Composite: Manager (can contain Employees and other Managers)
 *
 * Benefit:
 * You can treat a single Employee and a whole Manager/team
 * using the same interface: ->getSalary(), ->printStructure(), etc.
 */

/**
 * Component
 * Every node in the tree (Employee or Manager) follows this interface.
 */
interface OrgUnit
{
    public function getName(): string;

    /**
     * Real-life meaning: monthly salary cost of this unit.
     * - For Employee: their own salary
     * - For Manager: their salary + all subordinates' salaries
     */
    public function getMonthlyCost(): float;

    /**
     * Print org chart tree in a readable structure
     */
    public function printStructure(int $level = 0): void;
}

/**
 * Leaf
 * A simple Employee: has no children.
 */
class Employee implements OrgUnit
{
    public function __construct(
        private string $name,
        private float $monthlySalary
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getMonthlyCost(): float
    {
        // Leaf cost is just its own salary
        return $this->monthlySalary;
    }

    public function printStructure(int $level = 0): void
    {
        echo str_repeat("  ", $level) . "- Employee: {$this->name} (৳{$this->monthlySalary})\n";
    }
}

/**
 * Composite
 * A Manager can contain Employees and other Managers.
 */
class Manager implements OrgUnit
{
    /** @var OrgUnit[] */
    private array $children = [];

    public function __construct(
        private string $name,
        private float $monthlySalary
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Add a child node (Employee or another Manager).
     */
    public function add(OrgUnit $unit): void
    {
        $this->children[] = $unit;
    }

    /**
     * Remove a child node by matching name (simple approach).
     * In real apps you might remove by ID/reference.
     */
    public function removeByName(string $name): void
    {
        $this->children = array_values(array_filter(
            $this->children,
            fn (OrgUnit $unit) => $unit->getName() !== $name
        ));
    }

    public function getMonthlyCost(): float
    {
        // Manager cost includes their own salary + cost of all subordinates
        $total = $this->monthlySalary;

        foreach ($this->children as $child) {
            $total += $child->getMonthlyCost(); // Works for Employee AND Manager (composite magic)
        }

        return $total;
    }

    public function printStructure(int $level = 0): void
    {
        echo str_repeat("  ", $level) . "+ Manager: {$this->name} (৳{$this->monthlySalary})\n";

        // Print all children under this manager
        foreach ($this->children as $child) {
            $child->printStructure($level + 1);
        }
    }
}

/**
 * -------------------------
 * Real-life usage example
 * -------------------------
 * Build an org chart like:
 *
 * CEO
 *  - CTO
 *     - Dev1
 *     - Dev2
 *  - Finance Manager
 *     - Accountant
 */

$ceo = new Manager("CEO", 300000);

$cto = new Manager("CTO", 200000);
$cto->add(new Employee("Dev-1", 80000));
$cto->add(new Employee("Dev-2", 85000));

$financeManager = new Manager("Finance Manager", 150000);
$financeManager->add(new Employee("Accountant", 70000));

$ceo->add($cto);
$ceo->add($financeManager);

// Print org structure (treating everything uniformly)
echo "=== ORG STRUCTURE ===\n";
$ceo->printStructure();

// Get total monthly salary cost of the whole company under CEO
echo "\n=== TOTAL MONTHLY COST ===\n";
echo "Total Monthly Cost under {$ceo->getName()}: ৳" . $ceo->getMonthlyCost() . "\n";

// Example: you can also calculate cost for a sub-team only (CTO department)
echo "\nCTO Department Monthly Cost: ৳" . $cto->getMonthlyCost() . "\n";

// Example: Menu System
// This example demonstrates how to render a nested HTML navigation menu. The render() call on the top-level menu automatically triggers rendering for all sub-items.
interface MenuComponent {
    public function render(): string;
}

// Leaf: A simple link
class MenuItem implements MenuComponent {
    public function __construct(private string $title, private string $url) {}

    public function render(): string {
        return "<li><a href='{$this->url}'>{$this->title}</a></li>";
    }
}

// Composite: A dropdown or category
class MenuCategory implements MenuComponent {
    private array $items = [];

    public function __construct(private string $title) {}

    public function add(MenuComponent $item): void {
        $this->items[] = $item;
    }

    public function render(): string {
        $html = "<li><strong>{$this->title}</strong><ul>";
        foreach ($this->items as $item) {
            $html .= $item->render();
        }
        $html .= "</ul></li>";
        return $html;
    }
}

// Usage
$services = new MenuCategory("Services");
$services->add(new MenuItem("Web Design", "/design"));
$services->add(new MenuItem("SEO", "/seo"));

$mainMenu = new MenuCategory("Main Menu");
$mainMenu->add(new MenuItem("Home", "/"));
$mainMenu->add($services); // Nesting a composite inside a composite
$mainMenu->add(new MenuItem("Contact", "/contact"));

echo "<ul>" . $mainMenu->render() . "</ul>";

// **Decorator Pattern:
// Decorator is a structural design pattern that lets you attach new behaviors to objects by placing these objects inside special wrapper objects that contain the behaviors.
// Example: Today you are notifying via email, tomorrow you need slack, facebook, telegram notifications.
// Coffee Customization: You start with a basic coffee. You can "decorate" it with milk, sugar, whipped cream, or caramel. Each topping increases the price and adds a flavor, but the core object is still a coffee.
// Car Features: Imagine buying a base model car. You can add a sunroof, a high-end sound system, or heated seats. You aren't building a "CarWithSunroofAndHeatedSeats" class; you are wrapping the base car with optional features.
// Pizza toppings: Base pizza → +Cheese → +Olives → +Chicken
// Web request middleware: request handler → +Auth → +Rate limit → +Logging
// File streams: file stream → +Buffering → +Compression → +Encryption
// Without Decorator, you would need many subclasses for every combination of add-ons.
// Decorator solves it by letting you wrap a base object with multiple “add-on” objects at runtime.
/**
 * Component interface:
 * Everything that can be ordered as a "Beverage" must provide:
 * - getDescription()
 * - cost()
 */
interface Beverage
{
    public function getDescription(): string;
    public function cost(): float;
}

/**
 * Concrete Component:
 * A basic coffee with no add-ons.
 */
class Espresso implements Beverage
{
    public function getDescription(): string
    {
        return "Espresso";
    }

    public function cost(): float
    {
        return 120.00;
    }
}

/**
 * Base Decorator:
 * Holds a Beverage and implements Beverage too.
 * This is the key: decorators have the SAME interface as the object they wrap.
 */
abstract class AddOnDecorator implements Beverage
{
    protected Beverage $beverage;

    public function __construct(Beverage $beverage)
    {
        $this->beverage = $beverage;
    }

    // By default, delegate to wrapped object
    public function getDescription(): string
    {
        return $this->beverage->getDescription();
    }

    abstract public function cost(): float;
}

/**
 * Concrete Decorator: Milk
 * Adds Milk description + extra cost on top of wrapped beverage.
 */
class Milk extends AddOnDecorator
{
    public function getDescription(): string
    {
        return $this->beverage->getDescription() . ", Milk";
    }

    public function cost(): float
    {
        return $this->beverage->cost() + 20.00;
    }
}

/**
 * Concrete Decorator: Caramel
 */
class Caramel extends AddOnDecorator
{
    public function getDescription(): string
    {
        return $this->beverage->getDescription() . ", Caramel";
    }

    public function cost(): float
    {
        return $this->beverage->cost() + 30.00;
    }
}

/**
 * Concrete Decorator: WhippedCream
 */
class WhippedCream extends AddOnDecorator
{
    public function getDescription(): string
    {
        return $this->beverage->getDescription() . ", Whipped Cream";
    }

    public function cost(): float
    {
        return $this->beverage->cost() + 25.00;
    }
}

/* -------------------------
   ✅ Real usage (runtime composition)
   ------------------------- */

// Start with a base coffee
$order = new Espresso();

// Customer wants: Espresso + Milk + Caramel + Whipped Cream
$order = new Milk($order);
$order = new Caramel($order);
$order = new WhippedCream($order);

echo $order->getDescription() . PHP_EOL;
echo "Total: " . $order->cost() . " BDT" . PHP_EOL;

/*
Output:
Espresso, Milk, Caramel, Whipped Cream
Total: 195 BDT
*/

// **Facade Pattern: Facade is a structural design pattern that provides a simplified interface to a library, a framework, or any other complex set of classes.
// Imagine that you must make your code work with a broad set of objects that belong to a sophisticated library or framework.
// Ordinarily, you’d need to initialize all of those objects, keep track of dependencies, execute methods in the correct order, and so on.
// A facade is a class that provides a simple interface to a complex subsystem which contains lots of moving parts.
// Online Shopping: When you click "Place Order," the system checks inventory, verifies your credit card, calculates shipping, and sends a confirmation email. You only see one button; the Facade handles the rest.
// Facade provides a simple interface to a complex system.
// It hides internal complexity and exposes one clear entry point for the client.

// Wihout Facade:
// $inventory = new InventoryService();
// $inventory->checkStock($productId);

// $payment = new PaymentService();
// $payment->charge($userId, $amount);

// $order = new OrderService();
// $order->create($userId, $productId);

// $notification = new NotificationService();
// $notification->send($userId);

// With Facade:
class InventoryService
{
    public function checkStock(int $productId): void
    {
        // check stock availability
    }
}

class PaymentService2
{
    public function charge(int $userId, float $amount): void
    {
        // process payment
    }
}

class OrderService2
{
    public function create(int $userId, int $productId): void
    {
        // save order
    }
}

class NotificationService
{
    public function send(int $userId): void
    {
        // send email/SMS
    }
}

/**
 * Facade:
 * Provides a simple interface for placing an order.
 * Hides all internal complexity.
 */
class OrderFacade
{
    private InventoryService $inventory;
    private PaymentService2 $payment;
    private OrderService2 $order;
    private NotificationService $notification;

    public function __construct()
    {
        $this->inventory = new InventoryService();
        $this->payment = new PaymentService2();
        $this->order = new OrderService2();
        $this->notification = new NotificationService();
    }

    /**
     * One simple method to place an order
     */
    public function placeOrder(
        int $userId,
        int $productId,
        float $amount
    ): void {
        $this->inventory->checkStock($productId);
        $this->payment->charge($userId, $amount);
        $this->order->create($userId, $productId);
        $this->notification->send($userId);
    }
}
$orderFacade = new OrderFacade();
$orderFacade->placeOrder(10, 501, 2500.00);

// **Flyweight Pattern: The Flyweight Pattern is primarily used for optimization. It is designed to reduce memory usage when you need to create a vast number of similar objects (thousands or millions).
// Example: In a professional text editor (like MS Word), every single character on the page could be an object.
// The Problem: A 500-page book has roughly 1,000,000 characters. If each character is an object containing font type, size, and the glyph (image data), you'd need gigabytes of RAM just for text.
// The Flyweight Solution: You create only 26 "Flyweight" objects (one for each letter of the alphabet). Each object stores the font and shape. The "unique" part (the position on the page) is passed to the character object only when it needs to be drawn.
// 1. The Flyweight: This stores the "Intrinsic" state (The heavy data)
class TreeType {
    private $name;
    private $color;
    private $texture; // Imagine this is a large binary blob

    public function __construct($name, $color, $texture) {
        $this->name = $name;
        $this->color = $color;
        $this->texture = $texture;
    }

    public function draw($x, $y) {
        echo "Drawing a '{$this->name}' tree at ($x, $y) with color '{$this->color}'.\n";
    }
}

// 2. The Flyweight Factory: Manages and reuses the TreeType objects
class TreeFactory {
    private static $treeTypes = [];

    public static function getTreeType($name, $color, $texture) {
        $key = $name . "_" . $color;
        if (!isset(self::$treeTypes[$key])) {
            echo "--- Creating a NEW TreeType: $name ---\n";
            self::$treeTypes[$key] = new TreeType($name, $color, $texture);
        }
        return self::$treeTypes[$key];
    }
}

// 3. The Contextual Object: Stores the "Extrinsic" state (Unique data)
class Tree {
    private $x;
    private $y;
    private $type; // Reference to the Flyweight

    public function __construct($x, $y, TreeType $type) {
        $this->x = $x;
        $this->y = $y;
        $this->type = $type;
    }

    public function render() {
        $this->type->draw($this->x, $this->y);
    }
}

// --- Client Code ---

$trees = [];
$textures = ["RoughBark.png", "SmoothBark.png"];

// Create 1,000 trees, but only 2 types!
for ($i = 0; $i < 1000; $i++) {
    $x = rand(0, 100);
    $y = rand(0, 100);
    
    // We alternate between Oak and Pine
    if ($i % 2 == 0) {
        $type = TreeFactory::getTreeType("Oak", "Green", $textures[0]);
    } else {
        $type = TreeFactory::getTreeType("Pine", "Dark Green", $textures[1]);
    }
    
    $trees[] = new Tree($x, $y, $type);
}

// Even though we have 1,000 Tree objects, we only have TWO TreeType objects in memory.
echo "Total trees created: " . count($trees) . "\n";

// **Proxy Pattern: Proxy is a structural design pattern that lets you provide a substitute or placeholder for another object. 
// Here is an example: you have a massive object that consumes a vast amount of system resources. You need it from time to time, but not always.
// You could implement lazy initialization: create this object only when it’s actually needed. All of the object’s clients would need to execute some deferred initialization code. Unfortunately, this would probably cause a lot of code duplication.
// Instead of calling the real object directly, the client calls the proxy, and the proxy decides: when to create the real object etc.
// Proxy is needed when: large file, remote API, heavy DB operation, (authorization, permissions), Lazy loading is needed (load only when required)
// Real life example: Bank ATM System: You don’t access the bank vault directly, ATM checks PIN → balance → permissions → then gives moneys.
// Office Reception: ou cannot enter the office directly, Reception checks ID and permission
// Image loading on websites (Virtual Proxy): Large images load only when visible, Until then, a placeholder is shown.
// API Gateway (Remote Proxy): Client calls gateway, Gateway calls multiple backend services
// Example: Lazy-loading a Large Report (Virtual Proxy)

/**
 * Subject interface
 * Both Real object and Proxy must implement this
 */
interface Report
{
    public function display(): void;
}
/**
 * RealSubject
 * This class is expensive to create
 */
class SalesReport implements Report
{
    public function __construct()
    {
        // Simulate heavy operation (DB query, calculation)
        sleep(3); // expensive setup
        echo "SalesReport generated...\n";
    }

    public function display(): void
    {
        echo "Displaying full sales report\n";
    }
}
/**
 * Proxy
 * Controls access to SalesReport
 * Creates it only when required (lazy loading)
 */
class SalesReportProxy implements Report
{
    private ?SalesReport $realReport = null;

    public function display(): void
    {
        // Create real object ONLY when needed
        if ($this->realReport === null) {
            $this->realReport = new SalesReport();
        }

        // Delegate the call
        $this->realReport->display();
    }
}
$report = new SalesReportProxy();

echo "User logged in\n";
// No report generated yet

echo "User clicks 'View Report'\n";
$report->display();

// *Chain of Responsibility Pattern: behavioral design pattern that allows you to pass requests along a chain of handlers. 
// Upon receiving a request, each handler decides either to process the request or to pass it to the next handler in the chain.
// Examples: Middleware in Web Frameworks, Customer Support Systems, Approval Workflows
// Implementation1: we’ll build a support ticket handler where different departments handle specific types of issues.

// Contract for every "link" in the chain.
interface Handler {
    public function setNext(Handler $handler): Handler;
    public function handle(string $request): ?string;
}
// Boilerplate code for chaining, so concrete handlers only focus on their specific logic.
abstract class AbstractHandler implements Handler {
    private ?Handler $nextHandler = null;

    public function setNext(Handler $handler): Handler {
        $this->nextHandler = $handler;
        return $handler; // Returning the handler allows for "fluent" chaining
    }

    public function handle(string $request): ?string {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }
        return "No department could handle this request: " . $request;
    }
}
// Concrete Handlers
class BasicSupport extends AbstractHandler {
    public function handle(string $request): ?string {
        if ($request === "password_reset") {
            return "Basic Support: Handled the password reset.\n";
        }
        return parent::handle($request);
    }
}

class TechSupport extends AbstractHandler {
    public function handle(string $request): ?string {
        if ($request === "server_error") {
            return "Tech Support: Fixed the server error.\n";
        }
        return parent::handle($request);
    }
}

class BillingSupport extends AbstractHandler {
    public function handle(string $request): ?string {
        if ($request === "refund_request") {
            return "Billing Support: Processed the refund.\n";
        }
        return parent::handle($request);
    }
}
// Client Code:
// 1. Create the handlers
$basic = new BasicSupport();
$tech = new TechSupport();
$billing = new BillingSupport();

// 2. Build the chain: Basic -> Tech -> Billing
$basic->setNext($tech)->setNext($billing);

// 3. Send requests to the start of the chain
$requests = ["password_reset", "refund_request", "broken_screen"];

foreach ($requests as $req) {
    echo "Client: Requesting help with '$req'...\n";
    echo $basic->handle($req) . "\n";
}

// Example2: 
class ExpenseReport {
    public function __construct(
        public float $amount,
        public string $purpose
    ) {}
}
interface Approver {
    public function setNext(Approver $next): Approver;
    public function approve(ExpenseReport $report): string;
}

abstract class BaseApprover implements Approver {
    private ?Approver $nextApprover = null;

    public function setNext(Approver $next): Approver {
        $this->nextApprover = $next;
        return $next;
    }

    protected function passToNext(ExpenseReport $report): string {
        if ($this->nextApprover) {
            return $this->nextApprover->approve($report);
        }
        return "REJECTED: Amount of \${$report->amount} is too high for all departments.";
    }
}
class Manager2 extends BaseApprover {
    public function approve(ExpenseReport $report): string {
        if ($report->amount <= 500) {
            return "Manager approved '{$report->purpose}' (\${$report->amount}).";
        }
        return $this->passToNext($report);
    }
}

class Director extends BaseApprover {
    public function approve(ExpenseReport $report): string {
        if ($report->amount <= 5000) {
            return "Director approved '{$report->purpose}' (\${$report->amount}).";
        }
        return $this->passToNext($report);
    }
}

class CEO extends BaseApprover {
    public function approve(ExpenseReport $report): string {
        if ($report->amount <= 50000) {
            return "CEO approved '{$report->purpose}' (\${$report->amount}).";
        }
        return $this->passToNext($report);
    }
}
// Setup the chain
$manager = new Manager2();
$director = new Director();
$ceo = new CEO();

// Manager -> Director -> CEO
$manager->setNext($director)->setNext($ceo);

// Test cases
$reports = [
    new ExpenseReport(150, "Office Supplies"),
    new ExpenseReport(2500, "New Laptop"),
    new ExpenseReport(15000, "Trade Show Booth"),
    new ExpenseReport(100000, "Private Jet") // This will exceed the chain
];

foreach ($reports as $report) {
    echo $manager->approve($report) . PHP_EOL;
}

// *Command Pattern: Focuses on encapsulating a request as an object.
// This allows you to parameterize clients with different requests, queue or log requests, and support undoable operations.
class BankAccount {
    private float $balance = 0;

    public function __construct(private string $accountNumber) {}

    public function deposit(float $amount): void {
        $this->balance += $amount;
        echo "Deposited \${$amount}. New Balance: \${$this->balance}" . PHP_EOL;
    }

    public function withdraw(float $amount): bool {
        if ($this->balance >= $amount) {
            $this->balance -= $amount;
            echo "Withdrew \${$amount}. New Balance: \${$this->balance}" . PHP_EOL;
            return true;
        }
        echo "Insufficient funds for withdrawal of \${$amount}." . PHP_EOL;
        return false;
    }

    public function getBalance(): float {
        return $this->balance;
    }
}
interface Transaction2 {
    public function execute(): bool;
    public function undo(): void;
}
class DepositCommand implements Transaction2 {
    public function __construct(
        private BankAccount $account, 
        private float $amount
    ) {}

    public function execute(): bool {
        $this->account->deposit($this->amount);
        return true;
    }

    public function undo(): void {
        $this->account->withdraw($this->amount);
    }
}

class WithdrawCommand implements Transaction2 {
    private bool $succeeded = false;

    public function __construct(
        private BankAccount $account, 
        private float $amount
    ) {}

    public function execute(): bool {
        $this->succeeded = $this->account->withdraw($this->amount);
        return $this->succeeded;
    }

    public function undo(): void {
        if ($this->succeeded) {
            $this->account->deposit($this->amount);
        }
    }
}
class TransactionManager {
    private array $history = [];

    public function process(Transaction2 $transaction): void {
        if ($transaction->execute()) {
            $this->history[] = $transaction;
        }
    }

    public function undoLast(): void {
        if (!empty($this->history)) {
            $transaction = array_pop($this->history);
            echo "Undoing last transaction..." . PHP_EOL;
            $transaction->undo();
        } else {
            echo "No transactions to undo." . PHP_EOL;
        }
    }
}
$myAccount = new BankAccount("12345-PHP");
$manager = new TransactionManager();

// 1. Perform a deposit
$deposit = new DepositCommand($myAccount, 1000);
$manager->process($deposit); 

// 2. Perform a withdrawal
$withdrawal = new WithdrawCommand($myAccount, 200);
$manager->process($withdrawal);

// 3. Perform another withdrawal
$manager->process(new WithdrawCommand($myAccount, 50));

// 4. Whoops! The last withdrawal of 50 was a mistake. Undo it.
$manager->undoLast();

echo "Final Balance: $" . $myAccount->getBalance() . PHP_EOL;