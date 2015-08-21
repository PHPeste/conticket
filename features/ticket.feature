Feature: Allow an user to buy a ticket
    In order have access to an event
    As a logged user
    I want to be able to buy a ticket

    Scenario: Buy a ticket and paying it
        Given I am at event detail page
        When I select a ticket
        And I click in buy button
        And the payment order is create
        Then I should be redirect to the payment method page
        When I pay for get the ticket
        And I access my tickets page
        Then I should see a payment order success message
        And I should see a payment order payed

    Scenario: Buy a ticket and not paying it
        Given I am at event detail page
        When I select a ticket
        And I click in buy button
        Then I should be redirect to the payment method page
        When I access my tickets page without pay the order
        Then I should see a payment order waiting payment
