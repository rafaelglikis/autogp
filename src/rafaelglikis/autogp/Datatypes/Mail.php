<?php

namespace rafaelglikis\autogp\Datatypes;


class Mail
{
    private $receversMail;
    private $sendersMail;
    private $subject;
    private $message;

    public function getReceversMail(): string
    {
        return $this->receversMail;
    }

    public function setReceversMail(string $receversMail)
    {
        $this->receversMail = $receversMail;
    }

    public function getSendersMail(): string
    {
        return $this->sendersMail;
    }

    public function setSendersMail(string $sendersMail)
    {
        $this->sendersMail = $sendersMail;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }
}