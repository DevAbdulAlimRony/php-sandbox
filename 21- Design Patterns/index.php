<?php
// Design patterns are typical solutions to commonly occurring problems in software design.  
// The pattern is not a specific piece of code, but a general concept for solving a particular problem 
// Design patterns define a common language that you and your teammates can use to communicate more efficiently. 
// Design patterns differ by their complexity, level of detail and scale of applicability to the entire system being designedSome groups of patterns: Creational Patter, Structural Pattern, Behavioral Pattern. -->

// Creational Design Patterns:
// Creational design patterns provide various object creation mechanisms, which increase flexibility and reuse of existing code. 
// Types: Factory Method, Abstract Factory, Builder, Prototype, Singleton -->
// Factory Method:
// Factory Method is a creational design pattern that provides an interface for creating objects in a superclass, but allows subclasses to alter the type of objects that will be created. 
// Ex1: Application needs to send notifications, Desktop app send system notification, mobile app send push notification and so on. 
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
// Product Interface for the factory method implementation.
interface Notification
{
    public function send(string $message): void;
}

// Concrete Creator Class
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
// Pros: Solve problem for single responsibility class and open and closed principle
// Cons: So many subclasses.
// Ex2: Search Engines
interface SearchEngine {
    public function search(string $value): string;
}

class GoogleEngine implements SearchEngine
{
    public function search(string $value): string
    {
        return "Google: $value";
    }
}

class BingEngine implements SearchEngine
{
    public function search(string $value): string
    {
        return "Bing: $value";
    }
}

abstract class Search {
    abstract public function engine(): SearchEngine;

    public function query(string $search): string
    {
        return $this->engine()->search($search);
    }
}

class GoogleSearch extends Search
{
    public function engine(): SearchEngine
    {
        return new GoogleEngine();
    }
}

class BingSearch extends Search
{
    public function engine(): SearchEngine
    {
        return new BingEngine();
    }
}

$search = (new GoogleSearch())->query("Hello");
printf($search);

$search = (new BingSearch())->query("Hello");
printf($search);


