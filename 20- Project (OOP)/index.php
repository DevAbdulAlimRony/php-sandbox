<?php
// Full Project will be found here:
// 


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

// To make user's session, we can make an authenticated middleware 
// We can create auth interface user interface etc to abstract from the middleware to make code quality better 
// For logout, just set the session unset and make user object null within the auth class.
// We can implement session interface to start global session, validations and close.