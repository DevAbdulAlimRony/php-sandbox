<?php

use App;
use Symfony\Component\Mailer\MailerInterface;
// This script will be running in command line to sent scheduled email
// It won't be running in browser. So, we need to boot up our application to get access of config, autoloader etc.
// So, we need every code here from public.php for taking autloader, container, env files and all needed configurations. 
// Maybe we can make boot() method to boot everything in App.php and call it.

require_once __DIR__ . '/../vendor/autoload.php';
$container = new Container();
(new App($container))->boot();

// Sending Email
$container->get(EmailService::class)->sendQueueEmails();

class EmailService{
    public function __construct(protected EmailModel $emailModel, protected MailerInterface $mailer)
    {
    }

    // Sending Email
    public function sendQueueEmails(): void{
        // At first, fetch all emails from table which status is queued. Let's say its in $email var
        // Then loop over that emails and call new Email to send like we did for a mail sending
        // When sent, make sent_at at that current time.
        // Maybe take it in try catch, if failed logg exception.

        // If you want to attach something, maybe put that file in local or s3 type storage
        // Save filepath or location in databse (Json column or email_attachments table)
        // Locate the files and attach to the email while sending.

        // But how can we run this script automatically? This is where CORN help
        // CORN is a job scheduler tool for unique system, it let us run the script at automated scheduled time
        // The schedules are stored in CORNTab means CORN Table with 7 fields, first 6 for schedule and last one is command.
        // Field Values: Minute(0-59), Hour(0-23), Day(Month: 1-31), Month(1-12), Day(Week:1-7), Command or script that we want to run which is email.php for our case.
        // If we set minute 0, It will run every hour. If 30, it will be half hourly. 
        // We can set multiple values by comma like hour- 2,5- will run at 2 AM and 5 AM
        // Also by: 2-5(only in february to may), */2: run the script in every 2 minutes
        // In docker, we can run corn in a separate container
    }
}