<?php

class Member
{
    private $number;
    private $name;
    private $active;

    private function __construct($number, $name, $active)
    {
        $this->number = $number;
        $this->name = $name;
        $this->active = $active;
    }

    public static function fromDetails($number, $name, $active)
    {
        return new Member($number, $name, $active);
    }

    public function asArray()
    {
        return [
            $this->number,
            $this->name,
            $this->active
        ];
    }
}
