<?php
$firstname = "Peter";
$lastname = "Griffin";
$age = "41";
$result = compact("firstname", "lastname", "age"); // Create array containing variables and their values
$number = range(0,5); // Creates array from 0 to 5
print_r($number);