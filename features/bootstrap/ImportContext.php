<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class ImportContext implements Context, SnippetAcceptingContext
{
    private $importFile;
    private $membersList;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->membersList = new Fake\MembersList([]);
        $this->importFile = new Fake\ImportFile();
    }

    /**
     * @Given there is no file to import
     */
    public function thereIsNoFileToImport()
    {
        $this->importFile->doesNotExist();
    }

    /**
     * @When the import file is imported
     */
    public function theImportFileIsImported()
    {
        $importer = new \Importer($this->membersList, $this->importFile);
        $importer->import();
    }

    /**
     * @Then no members are added or updated to the members list
     */
    public function noMembersAreAddedOrUpdatedToTheMembersList()
    {
        if ($this->membersList->getMembers() !== []) {
            throw new \Exception('Members list changed!');
        }
    }

    /**
     * @Given the import file contains:
     */
    public function theImportFileContains(TableNode $table)
    {
        foreach ($table as $row) {
            $member = Member::fromDetails($row['number'], $row['name'], $row['active']);
            $this->importFile->addMember($member);
        }
    }

    /**
     * @Given the members list contains no members
     */
    public function theMembersListContainsNoMembers()
    {
        $this->membersList->clear();
    }

    /**
     * @Then the following member is added to the members list:
     */
    public function checkMembersAreInMemberList(TableNode $table)
    {
        foreach ($table as $row) {
            $member = Member::fromDetails($row['number'], $row['name'], $row['active']);
            if (!in_array($member, $this->membersList->getMembers())) {
                throw new \Exception('Member was not in list');
            }
        }
    }

    /**
     * @Then the import file will have been deleted
     */
    public function theImportFileWillHaveBeenDeleted()
    {
        if (!$this->importFile->hasBeenDeleted()) {
            throw new Exception('Import file was not deleted');
        }
    }

    /**
     * @Given the members list contains:
     */
    public function theMembersListContains(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Then the members list is updated to:
     */
    public function theMembersListIsUpdatedTo(TableNode $table)
    {
        throw new PendingException();
    }
}
