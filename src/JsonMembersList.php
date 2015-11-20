<?php

class JsonMembersList implements \MembersList
{
    /**
     * @var
     */
    private $file;

    private $members = [];

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function addMember(Member $member)
    {
        $this->members[] = $member->asArray();

        file_put_contents($this->file, json_encode($this->members));
    }
}