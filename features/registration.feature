Feature: Registration
  In order to have my own farm management area
  As a farmer
  I need to be able to register

  Scenario: Register
    Given I am on "/"
    When I follow "register"
    And I fill in "first_name" with "farmer"
    And I fill in "last_name" with "farmer"
    And I fill in "email" with "farmer@gmail.com"
    And I fill in "password" with "farmer"
    And I press "submit"
    Then I should be on "/registration/confirmed"
    And there is a farmer user "farmer" with password "farmer"