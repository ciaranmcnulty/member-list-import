<?php

namespace Fake;

class ImportFile implements \ImportFile
{
    private $members = [];
    private $hasBeenDeleted = false;
    private $doesNotExist = false;

    public function doesNotExist()
    {
        $this->doesNotExist = true;
    }

    public function addMember(\Member $member)
    {
        $this->members[] = $member;
    }

    public function hasBeenDeleted()
    {
        return $this->hasBeenDeleted;
    }



    public function getMembers()
    {
        if ($this->doesNotExist) {
            throw new \ImportFileNotFound();
        }

        return $this->members;
    }

    public function delete()
    {
        $this->hasBeenDeleted = true;
    }
}