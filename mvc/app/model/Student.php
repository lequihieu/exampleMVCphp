<?php

Class Student {

    public $name;
    public $age;
    public $email;


    public function __construct($name, $age, $email)
    {
        $this->name = $name;
        $this->age = $age;
        $this->email = $email;
    }
}