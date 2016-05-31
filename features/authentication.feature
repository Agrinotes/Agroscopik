Feature: Authentication
  In order to gain access to my farm management area
  As a farmer
  I need to be able to login and logout

  Scenario: Logging in
    Given there is a farmer user "farmer" with password "farmer"
    And I am on "/login"
    When I fill in "username" with "farmer"
    And I fill in "password" with "farmer"
    And I press "login"
    Then I should see "logout"