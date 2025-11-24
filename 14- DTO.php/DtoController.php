<?php
// While working in aan application, we often need to transfer data from point A to point B. Can e many things like api request etc.
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



