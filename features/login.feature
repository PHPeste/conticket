Feature: Allow a visitor to register and login
  In order to access the site functionalities
  As a web site visitor
  I should be able to register myself and log in the system

  Scenario Outline: Register a visitor
    Given I am at homepage
    When I click in the <social> login button
    Then I should see modal window with <social> request authorization page
    When I grant access to my account
    Then I should back to the homepage
    And I have to be logged in the system

    Examples:
      | social   |
      | twitter  |
      | facebook |
      | google   |

  Scenario Outline: Incomplete login
    Given I am at homepage
    When I click in the <social> login button
    Then I should see modal window with <social> request authorization page
    When I denied access to my account
    Then I should back to the homepage
    And I have to be not logged in the system

    Examples:
      | social   |
      | twitter  |
      | facebook |
      | google   |
