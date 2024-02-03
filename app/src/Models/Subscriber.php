<?php

namespace App\Models;

class Subscriber
{
    public $email;
    public $name;
    public $lastName;
    public $status;

    public function __construct($email, $name, $last_name, $status)
    {
        $this->email = $email;
        $this->name = $name;
        $this->lastName = $last_name;
        $this->status = $status;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
