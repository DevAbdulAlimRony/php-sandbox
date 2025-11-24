<?php

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
// cURL: Client URL which is used to transfer data with urls between networks with different protocols(FTP/SFTP, HTTP/HTTPS, POP3/IMAP)
// cURL (Client URL library) is a tool and PHP extension that allows you to send HTTP requests from your server to another server.
// To call external APIs, To make HTTP requests from your PHP backend, To send data like JSON, files, form data, To communicate with microservices  
// It is a package which provides library called libcurl and cli called curl.
// PHP supports livcurl and provide its function. But in order to use it, it needs to be installed in php.ini- extension=curl or can be set up in docker.
// We have HTTP client to do it in laravel
// In Laravel, you almost never use raw cURL because Laravel provides better tools: Http::class (Laravel HTTP Client — recommended), Guzzle (used internally by Laravel)

// Curl command: curl -s https://url.. It wil print the results in command line.

class CurlController{
    public function index(){
        $handle = curl_init(); // This function returns curl handle object
        $url = 'https://cpbangladeh.com'; // We will get the page from this link

        curl_setopt($handle, CURLOPT_URL, $url); // Set Options. CURKOPT_URL just show the page from the url
        // If we set CURLOPT_RETURNTRANSFER , true then we can store the full rendered htmlpage from cpbangladesh in a variable and curl_exec will return that result instead of true or false

        curl_exec($handle); // Return false or true

        // curl_getinfo(), curl_setopt_array(), curl_error()

        // API: Application Programming Interface: Way for multiple programms or devices to communicate with others.
        // Ex- I can make order in amazon using mobile, or any device from different designs or app.
        // Think the waiter of a resturent who took food from kitchen and deliver to you as api.
        // API Authentication: API Keys/Tokens (sent by header or request param), oAuth, Other or no auth
        // There are many response code api can have in response with respose body.
        // Response from API is usually in JSON (Javascript Object Notation) format, it can be in another formats, but its common.
        // JSON, or JavaScript Object Notation, is a lightweight text-based format for storing and transporting data that is easy for humans to read and for machines to parse.
        // We can use curl to make api request, in most cases no need, because most of the api has own sdk library

        $apiKey = $_ENV['EMAIL_API_KEY'];
        $email = 'alim15@cse.pstu.ac.bd'; // will come from a user input, not hard coded.
        $params = [
            'api_key' => $apiKey,
            'email'   => $email
        ];
        $url = 'https://api.emailable.com/v1/verify?' . http_build_query($params);
        // Now, we can pass that url to the curl options.

        // There are many libraries that work with curl and provide additional features.
        // One such library is guzzle which is a php http client and follows psr-7 standard.
        // Install Guzzle: composer require guzzlehttp/guzzle

        // $client = new Client([
        //     'base_url' => $url,
        //     'timeout'  => 5,
        // ]);

        // We can use retry middleware with exception handling also, so that if failed in client side, it can retry again and again at specific values with proper exception
        $stack = HandlerStack::create();
        $maxRetry = 3;
        $stack->push($this->getRetryMiddleware($maxRetry));

        $client = new Client([
            'base_url' => $url,
            'timeout'  => 5,
            'handler'  => $stack
        ]);

        $response = $client->get('verify-link..', ['query' => $params]);
        return json_decode($response->getBody()->getContents(), true);

    }

    private function getRetryMiddleware(int $maxRetry){
        return Middleware::retry(function (int $retries, RequestInterface $request, ?ResponseInterface $response = null, ?\RuntimeException $e = null) use ($maxRetry) {
            if($retries >= $maxRetry){
                return false;
            }
            if($response && in_array($response->getStatusCode(), [249,429,503])){
                return true;
            }
            if($e instanceof ConnectException){
                return true;
            }
            return false;
        });
    }

     // Refactoring:
        // Rather than hard coding this in controller's method, we can take a service class and inject it here with email argument
        // For API Key, we may have t switch to different account, then we will get different key. It would be much better, if we take that api key in constructor of the service class.
        // We can extract the base url as a property in the service class, because we can have multiple methods that can use that same url.
        // We can get our apikey of env variable into config file if we have to resolve our construtor's api_key of service class in app container. If a dependency's constructor have scalar params, not class object, we have to bind it in container.
        // Instead of Injecting Email Service , we can make it scalable using Email Interface so that new system can be used if arrived. maybe in Contracts or Interfaces folder.
        // We can make the retryMiddlware in a separate class and can inject in constructor of all service class
}