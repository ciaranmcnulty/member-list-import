<?php

class CsvImportFile implements ImportFile
{
    /**
     * @var
     */
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function getMembers()
    {
        $h = fopen($this->file, 'r');
        $members = [];

        while ($data = fgetcsv($h)) {
            $members[] = Member::fromDetails($data[0], $data[1], $data[2]);
        }

        return $members;
    }

    public function delete()
    {
        unlink($this->file);
    }
}