<?php
// Date Time Object:
$dateTime = new DateTime(); // we ca pass arguments like - tomorrow, tuesday noon, yesterday noon, 05/12/2024 2:03PM
$dateTime->setTimeZone(new DateTimeZone('Europe/Amsterdam'));
echo $dateTime->format('m/d/Y g:i A') . PHP_EOL;
$dateTime->getTimeZone()->getName();
$dateTime->setDate(2021, 4, 21)->setTime(2, 25);

$date = '15/05/2021 3:30PM'; // When use slash ameriacan month day year format, - or . will take day month year format, or:
$dateTime2 = DateTime::createFromFormat('d/m/Y g:iA', $date); // If time portion not present in both, it will set current time
// If You want midnight time, ->setTime(0, 0)

// Comapare Date Time Object
$dateTime1 < $dateTime2; // so, we can use comparisn operator

// Difference Between Two Date Time
$dateTime1->diff($dateTime2)->format('%Y years, %m months, %d days, %H, %i, %s'); // behind the scene- dateTime2 - dateTime1
// %a : Total Number of Days, %R%a: number of days with positive negative sign
// property: $dateTime1->diff($dateTime2)->days

// Interval Object
$interval = new DateInterval('P3M2D'); // 3 Months 2 Days Interval
$interval->invert = 1; // Positive Time Period, 0 is negative
$dateTime->add($interval); // sub()

// Operation on Date Object will change the Original Object. Ex Sol:
$from = new DateTime();
$to = (clone $from)->add(new DateInterval('P1M')); // Another Solution:

// Immutable Date Time Object
$from2 = new DateTimeImmutable();
$to2 = $from2->add(new DateInterval('P1M'));
// to perform any operation on immutable object, we have to reassign it on avariable:
$to2 = $to2->add(new DateInterval('P1M')); // If not reassigned, it will not add 

// Iterating Over a date Period
$period = new DatePeriod(new DateTime('05/01/2021'), new DateInterval('P1D'), new DateTime('05/31/2021')); // 1.5 to 30.5 in 1 day interval
// new DateTime('05/01/2021'), new DateInterval('P1D'), 3, DatePeriod::EXCLUDE_START_DATE')
foreach($period as $date){
    echo $date->format('d/m/Y'). PHP_EOL;
}

// Carbon Library: More Robust Solution on Date Time Object