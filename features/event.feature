@event
Feature: Allows interact and register events
  In order to share my event
  As a website user
  I should be able to register an event

  Background:
    Given application has following events:
      | name    | description                               | banner     |
      | PHPeste | The best event of PHP on Brazil northwest | banner.jpg |

  Scenario: Seeing events
    Given I do a request to event list page
     Then I should see 1 event listed
      And the response status code should be 200
      And I should see "PHPeste" on json response
      And I should see "The best event of PHP on Brazil northwest" on json response
      And I should see "banner.jpg" on json response

  Scenario: Creating a new event
    Given I do a request to event list page
     Then I should see 1 event listed
     When I "POST" to "/api/events" the following data:
       | name                     | description                               | banner     |
       | PHPeste - Second edition | The best event of PHP on Brazil northwest | banner.jpg |
     Then I should see "success" on last json response
      And the response status code should be 200 at last response
     When I do a request to event list page
     Then I should see 2 event listed

#  Scenario: Creating an event with tickets
#    Given I am at homepage
#    Then I should see no events registered
#    When I log in the system as a web site user
#    And I access the page for register an event
#    And I fill event name with "Event for test"
#    And I fill description with "Event for test"
#    And I select the banner "banner.jpg"
#    And I add a ticket with value "R$30,00" with name "Basic"
#    And I add a ticket with value "R$60,00" with name "Silver"
#    And I add a ticket with value "R$90,00" with name "Gold"
#    And I configure a gateway for payment
#    And save the event
#    Then I should see a message saying the event was saved
#    When I access the homepage again
#    Then I should see the event that was registered
#    When I follow the event detail link page
#    Then I should see a ticket "Basic" costs "R$30,00"
#    Then I should see a ticket "Silver" costs "R$60,00"
#    Then I should see a ticket "Gold" costs "R$30,00"
