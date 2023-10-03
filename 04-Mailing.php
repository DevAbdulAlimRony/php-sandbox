<?php
    $to = "alim15@cse.pstu.ac.bd";
    $from = "a.alim.cse.pstu@gmail.com";
    $subject = "Who are You?";
    $body = "Introduce Yourself. \n Dhuru";
    $headers = "From: {$from}\r\n";
    mail($to, $subject, $body, $headers);

    //If we want to send html mail
    $headers .= "MIME-Version:1.0 \r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $body .= "<img src=''>";

    //Sending Attachment: Very Complex

    //External Library: PHP Mailer- Send Mail with Attachment
    //Login to Mail, Authenticate and Send Mail- SMTP

?>