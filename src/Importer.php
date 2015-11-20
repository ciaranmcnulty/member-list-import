<?php

class Importer
{
    private $list;

    private $file;

    public function __construct(MembersList $list, ImportFile $file)
    {
        $this->list = $list;
        $this->file = $file;
    }

    public function import()
    {
        try {
            foreach ($this->file->getMembers() as $member) {
                $this->list->addMember($member);
            }

            $this->file->delete();
        }
        catch(ImportFileNotFound $e) {
            // stuff goes here
        }
    }
}
