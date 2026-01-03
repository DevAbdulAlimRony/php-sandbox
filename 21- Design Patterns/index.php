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



