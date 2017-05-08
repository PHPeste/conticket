@conference
Feature: Consuming conferences

  Scenario: Listing conferences
    Given I have one conference registered on the database
     When I ask for the list of conferences
     Then I should see 1 listed conference
      And I should see "PHPeste" on json response
     When I ask for the conference details
     Then I should see "PHPeste" on json response
