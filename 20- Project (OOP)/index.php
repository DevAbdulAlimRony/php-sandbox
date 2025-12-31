<?php
//** Authentication:
// Checking what is coming in request:
$data = $request->getParsedBody();
var_dump($data);

// Registering a User: Just save the data like name, email, password in databse normally using setter from model.
// You can encrypt name, emails if you want to make user's security at extra level. t’s not automatically “best practice, just Extra layer of data confidentiality.
// Some regulations and good-practice frameworks for privacy data recommend encryption of personally identifiable information (PII) when stored.
// If you store the decryption keys separately and securely (e.g. environment variables, hardware security module, “key vault”), it raises the bar for data thieves.
// Searching users by email or name becomes difficult. You’d need to decrypt every record (slow) or use searchable encryption (complex).
// If you need to use the email (e.g. send confirmation, password reset), you must decrypt it — increasing risk exposure and complexity.

// Password can be verifed as strong password for security purpose.
// Password can be hashed.You cannot get original password back from hash.
// Hashing one way process. Behind it, cannot rehashed the original text. But still its not alone secure enough for fast hash, slow hash, rainbow table, brute force, dictionary attacks.
// This is where hashing algorithm salting and other strategies come into play.
// You can use md5, sha1 but its not secure enough for password hashing. Attacker can use dictionary pattern with every combination of pass.
// We can check in CrackStation website if our hashed password can be cracked or not.
// Hashing is not same as encryption. Its two way process- We can encrypt and decrypt behind the scene using key.
// We should use slow hashing algorithm. 
//  Use password_hash() function in PHP to hash password before saving in database, its uses bcrypt algorithm by default which is one of the strongest algorithms available.
// Use password_verify() function to verify password during login.

password_hash('user_password', PASSWORD_BCRYPT, ['cost' => 12]);
// Default cost is 10, higher cost means more time to hash, more secure but more resource intensive, more cpu power slower generation harder to crack.
// There is a php script in docs to check cost for your server. 
// Different password should have different sault even if two users have same password. 
// If same password for one user for password confirmation, confirmation password should not be hashed and store in database, it is not secure.
// password_hash() does all of those complicated things automatically.

// Validation: To validate we can use library like valitron, symphony validation etc.
// We can make ValidationException middleware, also StartSessionMiddleware to flush or show the validation errors using $_SESSION['errors']
// We can make another middleware which will get the errors of session and give it to all views to print it.

// Session Based Authentication:
// We can use route middleware to decide which route to access if user logged in or already logged in and guest user or user who logged out.
// If user inputs validation passed and credentials matched, then store user id in session. If id got in session through the middleware, enter into the User Panel.
// For login validation, don't give specific error to the user like password incorrect or email not Found.
// Do like this: Email or Password is invalid.
// We will get session id in the browser. If user logged out and log in again, same session id generate. So, session hijaking or session fixation attack can happen.
// To protect agaings session attach: secure https connection, configure cookie option to ensure cookies are not accessible by javascript, XSS Protection, Regenarate session id if user logged in again.
// session_regenerate_id().
// Some browser's session id will be cleared if we close the browser. Chromium type browser stores session id, so we wont logged out after closing the browser.
// session_set_cookie_params(['secure' => true, 'httponly' => true, 'samesite' => 'lax'])

// Factory Pattern Explained:
class EmailSender
{
    public function send(string $message)
    {
        echo "Sending EMAIL: $message";
    }
}

class SmsSender
{
    public function send(string $message)
    {
        echo "Sending SMS: $message";
    }
}


class MessageService
{
    public function send(string $type, string $message)
    {
        if ($type === 'email') {
            $sender = new EmailSender();
        } elseif ($type === 'sms') {
            $sender = new SmsSender();
        }

        $sender->send($message);
    }
}
// The problem is here, MessageSErvice knows too much and it will groow in future.
// The solution is the factory pattern:
interface MessageSenderInterface
{
    public function send(string $message): void;
}
class EmailSender2 implements MessageSenderInterface
{
    public function send(string $message): void
    {
        echo "Sending EMAIL: $message";
    }
}

class SmsSender2 implements MessageSenderInterface
{
    public function send(string $message): void
    {
        echo "Sending SMS: $message";
    }
}
class MessageSenderFactory
{
    public function make(string $type): MessageSenderInterface
    {
        return match ($type) {
            'email' => new EmailSender2(),
            'sms'   => new SmsSender2(),
            default => throw new Exception('Unknown sender type'),
        };
    }
}
class MessageService2
{
    public function __construct(
        private MessageSenderFactory $factory
    ) {}

    public function send(string $type, string $message)
    {
        $sender = $this->factory->make($type); // You can pass type here as email or sms, or user selected value in request.s
        $sender->send($message);
    }
}

// AJAX: 
// Asynchronous JavaScript and XML) is a set of web development techniques used to create dynamic and interactive web applications that can send and receive data from a server in the background without reloading the entire page
// Exp- We get the category name and send to the frontend to bind in edit modal.
// xhr

// For sorting, we should provide default sorting direction and column to make sure no sql injection can happen.

// For search, We have to ensure that %, _, signs can be searched also, because by default it wont be searched.
// Those characters are called wildcard chars which are used in query params.
// To solve this, we can make those chars into / escaping as we do in html.
// $serach = str_replace(['%', '-'], ['\%', '\_', $search])
// Easy Way(use addcslashes- this basically use backslashes for given characters)
// $query->where('c.name ILIKE :name')->setParameter('name', '%', addcslashes($search, '%_' . '%'));
// To make user's session, we can make an authenticated middleware 
// We can create auth interface user interface etc to abstract from the middleware to make code quality better 
// For logout, just set the session unset and make user object null within the auth class.
// We can implement session interface to start global session, validations and close.
// Try always making interface rather than concrete class like Session implementation, in future different type Session implementation can come.

// CSRF(Cross-Site Request Forgery) Attack:
// CSRF is an attack that forces an end user to execute unwanted actions on a web application in which they're currently authenticated.
// Like attacker send a lin via email or chat to trick the user into executing actions of attacker's choosing
// For an Example- Bkash OTP
// Most of the frameworks provide csrf token protection.

// XSS (Coss Site Scripting)
// a type of injection in which malicious scripts are injected
// Maliscious code into the form..

// Whe we import so many data, we should use batch size to make performance better
// We can use clear method to prevent memory leak.

// Caching in Redis:
// Caching is when we store some data in a place from wheere you can get it super fast.
// Like if we need any thing, rather than going any source material, we are finding it in the nearest place.
// Our data in the database and we dont wanna fetch the data from database which is need to fetch over and over again.
// This is where redis ir memecache come in. Both are them in memory key valye storage systems.
// Redis stores data in memory which is faster to fetch rather than fetching from hard drive's database.
// Redis can handle all kinds of data and can be used for messaging system, queues etc aso besid caching.

// Step 1: Install Redis
// Step 2: Need to connect with PHP Redis Extension. or, Native PHP library Like Predis.
// Step 3: Implement proper Cache. There are two psrs related to psr- psr6 and psr16. psr16 is easy to use, psr6 complex but standard.
// Step 6: Install package psr-simple-cache package.
// Step 7: Now, Implement the RedisCache implements CacheInterface of psr. We will get get(), set(), delete(), clear(), getMultiple(), setMultiple(), deleteMultiple(), has() methods from that interface
// Step 8: Add Redis configuration files like host, port, password
// Step 8: Bind Interface in Container
// Step 9: use RedisCache class to cache.
// Laravel already provides the cache implementation, just use it.

// Rate Limiting:
// Rate Limiting is a technique for controlling the rate at which an application or API processes requests.
// How often a user can make request to the server.
// It prevents DDOs attacks.
// Rate limit can be done only for those requests which are resource intensive or sensitive to abuse.
// Ex- Complex database queries, login routes, password resets routes etc.
// But at the same you should avoid bad UX, so that user can get frustrated.
// We can create RateLimitMiddleware and use it.
// Like we have request from an IP or proxy IP, we take it into cache, and then check same IP requests at a specific count. Message- Too many attemts if user try to login with wrong info 5 times.

// Uploading files in s3 Bucket
// We can use Digital Ocean s3 adapter

