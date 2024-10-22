<?php
namespace App\SuperGlobal;
class RouteNotFoundException extends \Exception{
    protected $message = 'Route Not Found'; // overriden from PHP's Exception Class
}