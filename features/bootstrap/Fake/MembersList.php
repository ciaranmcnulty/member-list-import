<?php

namespace Fake;

class MembersList implements \MembersList
{
    private $members;

    public function __construct($members){

        $this->members = $members;
    }

    public function getMembers()
    {
        return $this->members;
    }

    public function clear()
    {
        $this->members = [];
    }

    public function addMember(\Member $member)
    {
        $this->members[] = $member;
    }
}