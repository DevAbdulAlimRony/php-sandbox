<?php
// Testing Types: 
// Accessibility Testing, Acceptence Testing, End to End Testing, Functional Testing, Integration Testing, Load Testing, Unit Testing Stress Testing, Regression Testing, Smoke tEsting etc.
// Unit and Integration Testing are important
// Unit Testing: Test small piece of code like single function and fakes any needed dependencies or database conncetions
// Integration Tests: Tests multiple modules or units together  like method that connect to database.
// There are many testing framework or tools: behat, PHPUnit etc.
// Accessibility Testing: Ensure the application is usable for people with disabilities.
// Acceptence Testing: Validate the application against business requirements.
// End to End Testing: Test the complete flow of the application from start to finish.
// Functional Testing: Verify that the application performs its functions as expected.
// Integration Testing: Check the interactions between different modules and services.
// Load Testing: Assess how the application behaves under heavy loads.
// Unit Testing: Focus on testing individual components in isolation.
// Stress Testing: Determine the limits of the application under extreme conditions.
// Regression Testing: Ensure that new changes do not break existing functionality.
// Smoke Testing: Perform a preliminary check to see if the application is stable enough for further testing.
// TDD(Test Driven Development): Write a Test, Execute Test which will surely be failed, then Implement Code to Success the Test. TDD is not standard for everyone, complicated, not preferred.
// BDD(Behavior Driven Development): Write a test, run the test, implement code and refactor. Same process as TDD but we write behaviors in simple english rather than test case.

// **PHP Unit
// composer require --dev phpunit/phpunit ^9.5
// After installing, we will get php unit script in vendor/bin
// Run Test: ./vendor/bin/phpunit TestController or whole directory test
// Configuring php unit: phpunit.xml file and basic configuration code copy

namespace Tests\Unit;
use App\SuperGlobal\RouteNotFoundException;
use PHPunit\Famework\TestCase;

class RouterTest extends TestCase {

    // Setup method will be called everytim tests run in this file
    // We needed object of Router multile times across the methods, so we centralize it. Now we can use $this->router in any method in this class.
    protected function setUp(): void{
        $this->router = new Router();
    }

    // We have to put that annotation @test or use prefix test for the method name to ensure that PHP knows it is a test and works
    /** @test */
    public function test_that_it_registes_a_route(): void{ 
        // When we call a register method
        $this->router->get('/users', ['Users', 'index']);
        $expected = [
            'get' => [
                '/users' => ['Users', 'index'],
            ],
        ];

        // Then we assert route was registered
        $this->assertEquals($expected, $this->router->routes());
        // assertWquals dont check strictly, If want strict check, use assertSame()
    }

    public function test_that_it_registers_a_post_route(): void{
        //........
    }

    public  function there_are_no_routes_when_route_is_created(){
        $router = new Router();
        $this->assertEmpty($router->routes());
    }

    /**
        * @test
        * @dataProvider routeNotFoundCases 
    */ 
    // There what we have passed as parameter, they will actually provided from routeNotFoundCases Data Provider
    // We must use that * @dataProvider routeNotFoundCases  and there are rules to write data provider method (must be public, must return array etc.)
    public function it_throws_route_not_found_exception(string $requestUri, $requestMethod): void{
        // We can also write annonymous classes to simulate
        $users = new class() {
            public function delete(): bool{
                return true;
            }
        };
        
        $this->router->post('/users', [$users::class, 'store']); // store method does not exist in the annonymous class, so it will be failed
        $this->router->post('/users', ['Users', 'index']);

        $this->expectException(RouteNotFoundException::class);
        $this->router->resolve($requestUri, $requestMethod);

    }

    public function routeNotFoundCases(): array{
        return [
            ['/users', 'put'],
            ['invoices', 'post'],
        ];
    }

    // We can also write Data Provider in an External Class
    // Then You have to Referencce fully Qualified Class Name- @dataProvider /Tests/DataProvider/routeNotFoundCases 
    // To Load that automatically, you have to add auto loading for test in composer.json
    // Data Provider is useful for validation check like put some valid data and put some invalid data

    // If a class have dependency, to write test of that class, we need mocking
    // Mocking in PHPUnit testing involves creating mock objects (also known as test doubles) that simulate the behavior of real objects or dependencies within a system under test. 
    // Lets Say we have a class called InvoiceService. The process needs three dependency- TaxService, paymentGatewayService, EmailService
    public function test_it_can_process_invoice(): void{
        $taxServiceMock = $this->createMock(TaxService::class);
        $paymentServiceMock = $this->createMock(PaymentGatewayService::class);
        $emailServiceMock = $this->createMock(InvoiceService::class);
        // If we hard coded (just called three classes in that InvoiceService and Use Them) dependency in Class, it creates problem.
        // But If we use dependency Injection to call them, Test will be easier.

        $paymentServiceMock->method('charge')->willReturn(true); // Always Return true no matter what

        // Given Invoice Service Class
        $invoice = new InvoiceService($taxServiceMock, $paymentServiceMock, $emailServiceMock);
        $customer = ['name' => 'Abdul'];
        $amount = 150;

        // When Process method is Called
        $result = $invoice->process($customer, $amount);

        // Then aseert Invoice is Proccessed Successfully
        $this->asserTrue($result);
    }
}
