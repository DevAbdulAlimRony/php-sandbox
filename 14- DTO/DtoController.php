<?php

use Request;
// A DTO is a simple object whose only job is to carry structured data between layers (Request → Service → Domain → API response) without business logic.
// While working in an application, we often need to transfer data from point A to point B. Can be many things like api request etc.
// DTO: Data Transfer Object is an object that carries data between processes.
// A DTO is a simple PHP class used to carry structured data from one part of your application to another.
// A DTO: has no business logic, has no database connection, only contains data in a strict, predictable format, prevents messy arrays from being passed everywhere, improves type safety
// No Business Logic or Behaviors. Its just a dummy class with some properties.

// Because PHP apps often pass around arrays full of inconsistent keys, like this:
$data = [
    'name' => 'John',
    'age' => '32',
    'is_active' => 'yes', // wrong type
];

// A DTO solves this by forcing a strict structure:
class UserData {
    public function __construct(
        public string $name,
        public int $age,
        public bool $active
    ) {}
}
// Rather than doing this- $input = $request->all(); which has to be passed in Services, Repositories, Actions, Job Queues; Instead use a DTO class then pass the DTO.
// Similar Concept of Laravel: Form Request, Eloquent Casts, Resource Collections.
// We can use readonly type of parameters of DTO Class Constructor, because DTO is typically immutable, once it created, value should never change afterwards. If want to change, just create another object.
// If you notice you have to take same array or data into multiple classes, then you can use DTO. If not, then no need to use for everything.
class IndexController{
    public function store(Request $request)
    {
        $order = $this->orderService->create($request->all());
    }
}
// Problems: Service depends on HTTP layer, Any new field breaks logic, No clear contract
// But with DTO, its clear and safe:
class CreateOrderDTO
{
    public function __construct(
        public int $userId,
        public array $items,
        public ?float $discount,
        public ?string $remarks
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            userId: (int) $request->user_id,
            items: $request->items,
            discount: $request->discount,
            remarks: $request->remarks
        );
    }
}

// Now service does not care about Http, DTO is reusable, IDE autocomplete works.
// Its now loosely coupled

// Tight Coupling: Giving your entire phone to someone so they can read one SMS
// Tight coupling is a design condition in which two or more software components are highly dependent on each other’s internal structure, implementation details, or concrete interfaces, such that a change in one component is likely to require changes in the other.

// Loose Coupling: Copying only the SMS text and giving it to them.
// Loose coupling is a design principle in which software components interact through well-defined, minimal, and stable interfaces, while remaining independent of each other’s internal implementation, allowing components to change or evolve without affecting other parts of the system.

// High Cohesion: A module has a single, well-defined responsibility.
// Low coupling + High cohesion = good design

// Abstraction: Exposing what a component does, not how it does it.
// Encapsulation: Hiding internal state and forcing interaction through controlled interfaces.
