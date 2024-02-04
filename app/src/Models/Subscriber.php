<?php

namespace App\Models;

class Subscriber
{
    public string $email;
    public string $name;
    public string $lastName;
    public string $status;

    public function __construct($email, $name, $last_name, $status)
    {
        $this->email = $email;
        $this->name = $name;
        $this->lastName = $last_name;
        $this->status = $status;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
