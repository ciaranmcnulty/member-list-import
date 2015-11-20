<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class ConsoleContext implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->filePath = sys_get_temp_dir() . '/importFile';
        $this->memberList = sys_get_temp_dir() . '/memberList.json';
    }

    /**
     * @afterScenario
     */
    public function deleteImport()
    {
        if (file_exists($this->filePath)) {
            unlink($this->filePath);
        }
        unlink($this->memberList);
    }

    /**
     * @Given the import file contains:
     */
    public function theImportFileContains(TableNode $table)
    {
        $data = '';

        foreach ($table as $row) {
            $data .= join(',', $row) . "\n";
        }

        file_put_contents($this->filePath, $data);
    }

    /**
     * @Given the members list contains no members
     */
    public function theMembersListContainsNoMembers()
    {
        touch($this->memberList);
    }

    /**
     * @When the import file is imported
     */
    public function theImportFileIsImported()
    {
        shell_exec('php import.php ' . escapeshellarg($this->filePath) . ' ' . escapeshellarg($this->memberList));
    }

    /**
     * @Then the following member is added to the members list:
     */
    public function theFollowingMemberIsAddedToTheMembersList(TableNode $table)
    {
        $members = json_decode(file_get_contents($this->memberList), true);

        foreach ($table as $row) {
            if (!in_array([$row['number'], $row['name'], $row['active']], $members)) {
                throw new \Exception('member is not in JSON');
            }
        }
    }

    /**
     * @Then the import file will have been deleted
     */
    public function theImportFileWillHaveBeenDeleted()
    {
        if (file_exists($this->filePath)) {
            throw new \Exception('File was not deleted!');
        }
    }
}
