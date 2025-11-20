<?php
// Old Way to Use Constants in a Class
class Status {
    const PENDING = 'pending';
    const APPROVED = 'approved';
}

// This is not a bad approach. Better than hard coding such values that dont really change and remain static.
// Problem: Sometimes, We need to verify that argument or parameter passed must matched the constants of that all() returned to make validation. But it will take some codes.
// There comes Enum to solve it.
// constants have three major problems that enums solve elegantly:
// 1. No Type Safety (Invalid values can pass silently, Hard to Validate):
function setStatus(string $status) {}

setStatus('apprroved'); // ❌ Typo — but PHP will accept it!
setStatus('xyz');       // ❌ Completely invalid — accepted!

// Enum Solved
enum Status2 {
    case PENDING;
    case APPROVED;
}
setStatus(Status::PENDING); // ✔️ OK
setStatus('pending');       // ❌ Error — strictly typed

// 2. PHP does not know these constants belong together logically. An enum defines a closed set.
// 3. Constants cannot have methods or logic.Enums can have methods
enum Status3 {
    case PENDING;
    case APPROVED;

    public function label(): string {
        return match($this) {
            self::PENDING => 'Waiting for Approval',
            self::APPROVED => 'Approved',
        };
    }
}

// Enums or Enumerations basically let us have a class that has a fixed set of possible values also known as cases.
// Enum class is just like a regular class which behaves exactly like a regular, just we write enum rather than class.
enum FarmerEnum {
    case PENDING; // Pure Case, no scalar value. This type of Enum called pure enum.
    case APPROVED;
    // Here, each case is a object of this class.
    // If we var_dump(FarmerEnum::PENDING), output will be a enum object. Can check with gettype(), is_object()
    // $obj1 = FarmerEnum::PENDING; $obj2 = FarmerEnum::PENDING; $obj1 == $obj2 will be true because they will be same instance.
}

class mainController {
    // We can Type Hint by Enum
    public function all(FarmerEnum $status){}
}
// mainController::all(999); - will throw error
// mainController::all(FarmerEnum::PENDING); - will work. But this argument is a object right? so we can get another error - Object of class cannot be converted to string
// In that case, we need to provide scalar value of the enum's case.

// Backed Enum (Cases with Scaler Values)
enum FarmerEnum2: int
{
    case Pending = 0; // Backed Case
    case Approved = 1;

    // Must have type hint, if not, wont work. Must be single data type, not this- int|string. Must be int or string
    // Must all cases have value. One value cannot be for multiple Case.
    // Cant mix pure cases and backed cases. Cases name and value must be unique.

    // We can write method into enum to make our cases human readale. or to convert the eum object to string
    public function toString(): string{
        return match ($this) {
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            default => 'Approved'
        };
    } // Now if we call FarmerEnum2::Pending we will get the string back.

    // Different Color based on Case
     public function color(): string{
        return match ($this) {
            self::Pending => 'yellow', // or, Color::green- so we are not hardcoding, taking another Enum.
            self::Approved => 'green',
            default => 'green'
        };
    }  // In view now: <td class="color-<?=FarmerEnum2::tryFrom($farmerObject)->color()....."
}

// Accessing Backed Cases: $status = new FarmerEnum2(); $status->name (Output the cases like APPROVED), $status->value

// Enum classes can implements interface and can use trait. But it cannot use inheritence.
// If trait has a property, we cannot use that trait in a Enum class.

// Not Allowed in Enum: Constructors and Deconstructors, Inheritence and Properties, Cloning, Magic Methods except __call, __callStatic, __invoke; Instantitaion directly or via reflection api
// Allowed: Public Private or Protected Methods, Static Methods and Constants, Interfaces, Traits without Properties, Enum Class Attribute, Enum Case Attribute


// $enum->name, value, cases (Provide all cases with values)
// Check if the given enum exists: enum_exists()

// Use Enum Classes with Reflection API: ReflectionEnum, ReflectionEnumUnitCase, ReflectionEnumBackedCase
