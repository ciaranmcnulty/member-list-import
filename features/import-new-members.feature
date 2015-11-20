Feature: Importing new members
  As a customer
  I would like my members to be imported automagically
  So that I can start using the system more quickly

  Rules
  - files uploaded by customer to FTP

  Scenario: Nothing happens if file is not present
    Given there is no file to import
    When the import file is imported
    Then no members are added or updated to the members list

    @critical
  Scenario: New members in file are imported into the members list
    Given the import file contains:
      | number | name   | active |
      | 12345  | Ciaran | true   |
    And the members list contains no members
    When the import file is imported
    Then the following member is added to the members list:
      | number | name   | active |
      | 12345  | Ciaran | true   |
    And the import file will have been deleted

    @wip
  Scenario: Members already in members list are updated
    Given the import file contains:
      | number | name   | active |
      | 12345  | Ciaran | true   |
    And the members list contains:
      | number | name   | active |
      | 12345  | Cn     | true   |
    When the import file is imported
    Then the members list is updated to:
      | number | name   | active |
      | 12345  | Ciaran | true   |
    And the import file will have been deleted


