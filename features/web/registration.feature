Feature: Registration
  In order to have my own farm management area
  As a farmer
  I need to be able to register

  Scenario: Register
    Given I am on "/register"
    When I fill in "email" with "farmer@gmail.com"
    And I fill in "fisrt_name" with "Jackie"
    And I fill in "last_name" with "Chan"
    And I fill in "password" with "farmer"
    And I press "register_submit"
    Then I should be on "/registration/confirmed"
    And there is a farmer user "farmer@gmail.com" with password "farmer"