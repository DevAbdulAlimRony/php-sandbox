<?php
// Let's say we are doing a shipping cost calculation
// Let's say we have dimensions, weight, dim weight, bill weight
// Billable weight is dimensional weight or actual weight which is higher.
// See Other controllers for those implementation
class BillableWeightCalculationService{
    public function calculate(int $width,
                             int $height, 
                             int $length, 
                             int $weight, 
                             int $dimDivisor): int
    {
        $dimWeight = (int) round($width * $height * $length / $dimDivisor);
        return max($weight, $dimWeight);
    }
}

$package = [
    'weight' => 6,
    'dimensions' => [
        'width' => 9,
        'length' => 15,
        'height' => 7
    ],
];
$fedexDimDivisor = 139;

$billableWeight = (new BillableWeightCalculationService())->calculate(
    $package['dimensions']['width'],
    $package['dimensions']['height'],
    $package['dimensions']['length'],
    $package['weight'],
    $fedexDimDivisor
);

// But for each argument we need validation , for each argument we need unit also (maybe we are using inch now, it can be another metric in future)
// So, those arguments along with validation and unit are not only scalar data anymore, it needs more additional information.
// That's wher value object could be a better alternative rather than manually doing them in complex way.

// Value object is a small object that represents a simple entity whose equality is not based on identity.
// Two value objects are equal when they have same values, not necessarily being the same object.
// Entity has id identity, value objects dont really have a specific identifier.
// Thetype of object where the equality is based upon the property values, is value object
// Value object ususally represnts quantifyable, measurable like amount, weight, address, phone number, age, dimension etc.

// Now, same example with value object
class BillableWeightCalculationServiceUpdated{
    public function calculate(PackageDimension $packageDimension,
                             int $weight, // We can also make it as value object. Weight $weight, Weight another class
                             int $dimDivisor): int
    {
        $dimWeight = (int) round($packageDimension->width * $packageDimension->height * $packageDimension->length / $dimDivisor);
        return max($weight, $dimWeight);
    }
}

// We dont need to make dimDivisor as a value object because it ddint have additional so much info
// We can use that DimDivisor as a constant or ENUM
// Reach for value object only when it needs, dont create value object only for validation.
// Value object is usually used in Domain Driven Design or in other architecture

// This class's constructor's parameters here are value object
class PackageDimension{

    // Value Object must be immutable, cant change outside the class. So, we added readonly
    public function __construct(public readonly int $width, 
    public readonly int $height, public readonly int $length){
        // It should be valid, value object by default is invalid. So , we have to make validation.
        match(true){
             $this->width <= 0 || $this->width > 80 => throw new \InvalidArgumentException('Invalid Package Width'),
            $this->height <= 0 || $this->height > 70 => throw new \InvalidArgumentException('Invalid Package Height'),
            $this->width <= 0 || $this->width > 120 => throw new \InvalidArgumentException('Invalid Package Length'),
            default => true,
        };
    }

    // Value Object should also be side effect free, readonly will do that. Now we cant increment width and others inside the class also by any method. It will be side effect free.
    // But we can create a new object to increase width, This will not cause any side effect.
    public function increaseWidth(int $width): self{
        return new self($this->width + $width, $this->height, $this->length);
    }

    // We can make the unit also

    // Value Object Comparisn:
    // Normally == is loose comprisn, for objects, it compares property values
    // Normally ===, strict comparisn, for objects it compares object identity(reference)
    // For strict coparisn, we can do here:
    public function equalsTo(PackageDimension $other){
        return $this->width === $other->width &&
            $this->height === $other->height &&
            $this->length === $other->length;
    }

}

// Value Objcet can have business logic where DTO not need.
// Real Life Example: We can make a phone number validated or email validated entirely

// Laravel itself does not officially have Value Objects, but Laravel offers concepts that behave like VOs.
// Custom Casts — Closest to Value Objects
// DTOs + Value Objects work very well together.
