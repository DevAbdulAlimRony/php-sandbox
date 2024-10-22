<?php
session_start(); // Discussed Below 
// Super Globals are Built In Variables which are always Available in All Scopes
// $GLOBALS, $_SERVER, $_REQUEST, $_POST, $_GET, $_FILES, $_ENV, $_COOKIE, $_SESSION
print_r($_SERVER); // Contains info about server and execution environment, vary server to server depending on your server configuration
// Use Case: Building Basic Routing

$router = new \App\SuperGlobal\Router();

$router->registerBasic('/any-url', function () {
    echo 'I am in any-url route';
});
$router->registerBasic('/', [\App\SuperGlobal\Home::class, 'index']);

// register method returns the self object, so we can chain it
$router->registerBasic('/home', [\App\SuperGlobal\Home::class, 'index'])
       ->registerBasic('/form-request', [\App\SuperGlobal\FormRequest::class, 'index'])
       ->registerBasic('/form-request/create', [\App\SuperGlobal\FormRequest::class, 'create']);

// echo $router->resolve($_SERVER['REQUEST_URI']);
// This Type Route calling will only support GET Request


// Improving Routes to accept POST Request Also
$router->get('/home', [\App\SuperGlobal\Home::class, 'index'])
       ->get('/form-request', [\App\SuperGlobal\FormRequest::class, 'index'])
       ->get('/form-request/create', [\App\SuperGlobal\FormRequest::class, 'create'])
       ->post('/form-request/store', [\App\SuperGlobal\FormRequest::class, 'store']);
echo $router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));

// Sessions and Cookies:
// Cookies are stored on a client's site on user's computer while session is stored in server side
// Session is destroyed as soon as browser closed, cookies maintains expiry date or until delted 
// If we start a session after output (ex- echo, in html body), it will give headers already sent error. Never do that
// In browser now, we wont see the error for output buffering. To test error, set output_buffering - 0 in php.ini
// starting session (session_start()) above of the code is best practice
// When session started, it will create a unique session id and it will write it into cookie and the session id cookie will be sent on every request after
// Check how stored SESSION superglobal  in Home.php and removed in FormRequest.php
var_dump($_SESSION); // Accessing Session. When visit home, count increase. When visit fom-request, count unset

// Cookie can be used for session management, tracking targeteed ads, enhanced user experience
// See How we create cookie in Home.php
// As like as session, setcookies() before any output
// Accessing Cookie:
var_dump($_COOKIE);
// We can delete cookie by setting expiry time on the past- See FormRequest.php
// We should not store any sensitive information in cookies

// File Upload: See Home.php
$router->post('/upload', [\App\SuperGlobal\Home::class, 'upload']); // route to upload by post method
define('STORAGE_PATH', __DIR__ . '/storage'); // file storage path defined
