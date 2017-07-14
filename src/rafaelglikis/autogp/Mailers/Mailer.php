<?php

namespace rafaelglikis\autogp\Mailers;
use rafaelglikis\autogp\Datatypes\Mail;

class Mailer
{
    static function sendMail(Mail $mail)
    {
        $headers = "From: " . $mail->getSendersMail() . "\r\n"
            . "Reply-To: " . $mail->getSendersMail() . "\r\n";

        mail($mail->getReceversMail(), $mail->getSubject(), $mail->getMessage(), $headers);
    }

    static function sendHtmlMail(Mail $mail)
    {
        $headers = "From: " . $mail->getSendersMail() . "\r\n"
            . "Reply-To: " . $mail->getSendersMail() . "\r\n"
            . "MIME-Version: 1.0\r\n"
            . "Content-Type: text/html; charset=ISO-8859-1\r\n";

        mail($mail->getReceversMail(), $mail->getSubject(), $mail->getMessage(), $headers);
    }
}