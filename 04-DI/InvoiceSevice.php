<?php
// In software engineering, dependency injection is a technique in which an object receives other objects that it depends on, called dependencies
// Receiving object is calling client, passed-in injectd object is called a service.
// The code that passes the service to the client is called the injector

// The Code belowis hard coded, Tight Coupling, Harder to Test, Harder to Maintain
class BadInvoiceService{
    protected PaymentGatewayService $gatewayService;
    protected SalesTaxService $salesTaxService;
    protected EmailService $emailService;

    public function __construct(){
        $this->gatewayService = new PaymentFatewayService();
        //.....and others
    }
}

// This code below maintains dependency injection following standard of IOC (Inversion of Control)
// Inversion of Control is a common phenomenon that you come across when extending frameworks. Indeed it's often seen as a defining characteristic of a framework.
class GoodInvoiceService {
   public function __construct(
    protected SalesTaxService $salesTaxService,
    protected PaymentGatewayService $gatewayService,
    // others...
   ){}
}

// Or We can Use Interface like SalesTaxInterface, PaymentGatewayInterface

// But we injected that dependencies, it wont instantiate or resolved object majically like laravel, right?
// So, we need dependency injection container here to pass that dependent object 
// Dependency Injection Container is simply a class that has information of other classes which allow us to resolve the dependencies perfectly
// PSR-11 gave use standard rules and implementation to build a DI Container , Container Interfaces
// We can use package or framewrok like PHP-DI, Laravel alreafy included DI Container as Service Container, so that we dont need to headache about container implementation.


// Making a DI Container:
// First install: composer require psr/container, Then take a Class called Container.php
//.......................
use Psr\Container\ContainerInterface;
class Container implements ContainerInterface{
    private array $entries = []; // storage that will hold all the registered services/classes.

    // Id here the class to resolve
    public function get(string $id){
        // If Dependency Class Not Found
        if(! $this->has($id)){
            throw new NotFoundException(); // We need to implement this class which extends Exception class and implements PSr NotFoundExceptionInterface
        }

        $entry = $this->entries[$id];
        return $entry($this);
    }

    public function has(string $id): bool{
        return isset($this->entries[$id]); // Checks if something is registered in the container.
    }

    public function set(string $id, callable $concrete){
        $this->entries[$id] = $concrete;
    }

    // Now we can register a class in the container like this - maybe in App.php
    // private static Container $container, in constructor: static::$container->set(InvoiceService::class, function(Container $c){ return new InvoiceService($c->get(TaxService::class)...) })
    // We also have to make entry for those Tax, PaymentGateway Service in container, because they are dependencies also
    // We can also implement autowiring by reflection api so that we dont need to call the Container class explicitly. Use resolve() method in get and implement it.

    public function resolve(string $id){
        // 1. Inspect the class that we are trying to get fom the container
        $reflectionClass = new \ReflectionClass($id);
        if($reflectionClass->isInstantiable()){
            throw new ContainerException("Class" . $id . "is not instantiable"); // PSR 11 has ContainerExceptionInterface
        }

        // 2. Inspect the constructor of the Class
        $constructor = $reflectionClass->getConstructor();
        if(! $constructor){
            return new $id; // If class has no constructor, just simply create a object of the class
        }

        // 3. Inpect the constructor parameters (dependencies)
        $parameters = $constructor->getParameters();
        if(! $parameters){
            return new $id; // If constructor has no parameter, just simply create a object of the class
        }

        // 4. If the constructor parameter is a class then try to resolve those class using the constructor
        $dependencies = array_map(function (\ReflectionParameter $param) use ($id) {
            $name = $param->getName(); // Get Class Name
            $type = $param->getType(); // get Class Type, So we need ty type hint the classes in constructor when We create oUr Service

            if(! $type){
                throw new ContainerException('Failed to resolve class' . $id. "because" . $name . "has no type");
            }

            // But what if the type is not a class, just string or int, throw exception. So we need Dependencies as Class
            if($type instanceof \ReflectionUnionType){
                throw new ContainerException('Failed to resolve class' . $id. "because" . $name . "type is not a class");
            }

            // Finally resolve the constructor's paramete of the Dependendency Class
            if($type instanceof \ReflectionNamedType && ! $type->isBuiltin()){
                return $this->get($type->getName()); // Here we will get the full class name of the dependenxies' dependency
            }

            throw new ContainerException('Failed to resolve class ' . $id . 'because invalid param ' . $name);
        }, $parameters);

        return $reflectionClass->newInstanceArgs($dependencies);  // Return object or instance of all dependency Classes

        // After this resolve() method, now we can inject dependency without any explicit binding
        // (new Container())->get(InvoiceService::class)->process([], 25)
        // But we have to still call the new Container(), but the ideal calling should be from a constructor, just call the dependency
        // Now, in Router class, if we instantiate the container in constructor, then we can use inject dependencies ideally
        // In Container, we need more support like singleton support, cache support etc.
        // What if We want to inject Interface rather than a concrete class, so we need interface support also in the container
        // Laravel provides all support
    }
}