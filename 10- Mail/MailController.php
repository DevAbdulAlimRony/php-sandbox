<?php
// To send email, there is a native way called mail like this mail(string $to....)
// But due to its limited functionality with attachment, deliverity, we should use third party package.

// SMTP (Outbound Emails): Simple Mail Transfer Protocol used to deliver email from email client to email server or to one email server to another email server.
// When you write email and click send button, client or sender opens up a tcp connection to the smtp server
// Then email server does some stuffs then send it to the recipient
// SMTP is only for sending and delivring email, so it works with other protocols
// IMAP or POP3 protocol used for retriving or recieving emails
// IMAP- Internet Message Access Protocol (Inbound Emails), It does not delete the email on the server and can be synced with multiple servers
// POP3 - Post Office Protocol (V3) [Inbound Emails], POP3 by default deletes the email after recipent read it.

// Symfoy Mailer Package:
// composer require symfony/mailer
// Example- WE are registering user in the UserController, and sending email in register.php

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

class MailController{
    public function register(){
        $text = <<<Body
                    Hello Rony, Thank You for registering! 
        Body;

        // In addition to plain text we can send html as email also
        $html = <<<HTMLBODY
            <h1 style="color:green">Hi</h1><br>
        HTMLBODY; // Rather than using like this, we can use view code, then render it in controller as string, then pass the string.
        // You also can use only html and then parse the html into plain text to send it along with html.

        // To send an email using symfony mailer, we need few things, we need transport object, mailer service and actual email message object.
        // WE should send both html and text. If any user's does not support html, it will automatically fallbact to plain text

        // Actual Email Message Object
        $email = (new Email())
            ->from('alim15@cse.pstu.ac.bd')
            ->to('dummy@gmail.com')
            ->subject('Welcome')
            ->attach('Hi', 'hi.txt') // We can attach file here
            ->text($text)
            ->html($html);

        // Making Transport Object
        // DSN stands for Data Source Name, it is a string that represents the location or database connection or filesystem location or in that case Email Transport Information
        // In symfony documentation, we will get the dsn for each protocol, we will use dsn of smtp. We could use real gmail smtp, but we are testing, so we will just use dsn of our local testing server smtp.
        // There are some paid or free services for testing email server like mailtrap or open source packages like mailhog.
        // Install mailhog, can be installed by docker. Ex- in docker open ports 8025 for web ui where we can expose our inbox and 8025 for smtp server
        // $dsn = 'smtp://user:pass@smtp.example.com:25';- Here, we have to put our smtp's user and password here. This is for if we use mailtrap like service
        
        // This is for mailhog. docker-containername:smtp-port. Rather than hard coding, we should put dsn string in env variable then use it by Env super global- $_ENV['MAILER_DSN']
        $dsn = 'smtp:mailhog:8025'; 
        $transport = Transport::fromDsn($dsn);

       // Send by Mailer Service
       // There are three built in trasport- smtp, sendmail, native. Others can be used like Amazon SES, Google Gmail, MailChimp, MialGun etc.
       // If we Mailer Class, we will see a constructor which has a required Trasporter object Interface and only one method called send(). The Transporter is a Interface there because we have so many options or protocols available to use.
       // Now, in Mailer object, we have to pass a trasporter objcet.
       $mailer = new Mailer($transport);
       $mailer->send($email); // Without Dependency Injection
       // $this->mailer->send($email);- With Dependency Injection: Calling Mailer and Traporter directly in Controller is not a OOP Way, we can do dependency injection by constructor, Thats the professional way and refactorred code. We can make a MailerInterface then can call in Constructor.

       // Now, we can go to the localhost:8025 and we will see the mailhog mailing ui to test.


       // Scheduling Email: Sending emails can take time. We can make schedule and run automated php script in background 
       // then can pick up the emails in queue and send them out.
       // Let's say we created a table called email which has subject, status(queue, sent, failed- maybe from a enum), text_body, html_body, meta, created_at, sent_at
       (new EmailModel())->queue(
            new Address('from@gmail.com'), 
            new Address('to@gmail.com', 'Abdul Alim'), 
            $html, $text
       ); // Its just inserting data into emails table
       // Now, other task to sent email at right time, we created scripts->email.php
    }
}

class EmailModel{
    public function queue(Address $to, Address $from, string $html, ?string $text = null){
            // Insert data into emails table at first, normal insertion process.
    }
}