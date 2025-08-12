<?php
// In software engineering, dependency injection is a technique in which an object receives other objects that it depends on, called dependencies
// Receiving object is calling client, passed-in injectd object is called a service.
// The code that passes the service to the client is called the injector

// The Code belowis hard coded, Tight Coupling, Harder to Test, Harder to Maintain
// class InvoiceService{
//     protected PaymentGatewayService $gatewayService;
//     protected SalesTaxService $salesTaxService;
//     protected EmailService $emailService;

//     public function __construct(){
//         $this->gatewayService = new PaymentFatewayService();
//         //.....and others
//     }
// }

// This code below maintains dependency injection following standard of IOC (Inversion of Control)
// Inversion of Control is a common phenomenon that you come across when extending frameworks. Indeed it's often seen as a defining characteristic of a framework.
// class InvoiceService {
//    public function __construct(
//     protected SalesTaxService $salesTaxService,
//     protected PaymentGatewayService $gatewayService,
//     // others...

//    ){}
// }
// Or We can Use Interface like SalesTaxInterface, PaymentGatewayInterface

// But we injected that dependencies, it wont instantiate or resolved object majically like laravel, right?
// So, we need dependency injection container here to pass that dependent object 
// Dependency Injection Container is simply a class that has information of other classes which allow us to resolve the dependencies perfectly
