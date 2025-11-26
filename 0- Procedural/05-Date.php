<?php
$currentTime = time(); // Current Unique Timestamps in seconds since January 1, 1970, 00:00:00 UTC
echo $currentTime + 5 * 24 * 60 * 60; // Added 5 Days, Timestamp of 5 Days Ago
echo $currentTime - 60 * 60 * 24; // Subtract 1 Day, Timestamp of Yesterday
echo date('d/m/Y g:ia'); // Formated Date Time, g represents hour, i represents minute, a rpresent pm or am
echo date('d/m/Y g:ia', $currentTime + 5 * 24 * 60 * 60); // Formatted Date after 5 Days from Now

// By Default, PHP use configuration of php's date time zone. But we can change it
date_default_timezone_set('UTC');
echo date_default_timezone_get(); // Output Type: America/New_York

echo date('m/d/y g:ia', mktime(0,0,0,4,10,null)); // Current Year, 4 Month, 10 Date, 12:00 am
echo date('m/d/y g:ia', strtotime('2021-01-18 07:00:00')); // Convert String To Time
// strtotime argument ca be- tomorrow, first day of february, last day of march, last day of february 2020, second friday of january etc
date_parse($currentTime); // Date into an array now with key year, month, day, hour, minute, second, fraction, is_localtime ...
date_parse_from_format('m/d/Y g:ia', $currentTime); // same, just specified format of argument passed