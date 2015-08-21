Feature: Allow a user to apply cupom discount
  In order to obtain a discount
  As a website user
  I should be able to use a cupom

  Scenario: Apply a valid cupom
    Given I am at event detail page
    And the ticket cost R$99,00
    When I apply valid cupom code of R$10,00
    Then I should see the R$10,00 of discount
    And the final amount should be R$89,00

  Scenario: Apply an invalid cupom
    Given I am at event detail page
    And the ticket cost R$99,00
    When I apply invalid cupom code
    Then I should see an invalid cupom message
    And the final amount should be R$99,00

  Scenario: Apply an expired cupom
    Given I am at event detail page
    And the ticket cost R$99,00
    When I apply expired cupom code
    Then I should see an expired cupom message
    And the final amount should be R$99,00

