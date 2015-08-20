Feature: In order to share my event
  As an web site user
  I should be able to register an event on the conticket website

  Scenario: Creating an event
    Given I am on the conticket homepage
    Then I can see that don't have events registered
    When I log in the system as a web site user
    And I access the page for register an event
    And I fill event name with "Event for test"
    And I fill description with "Event for test"
    And I select the banner "banner.jpg"
    And I configure a gateway for payment
    And save the event
    Then I should see a message saying the event was saved
    When I access the conticket homepage again
    Then I should see the event that was registered
