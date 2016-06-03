Feature: Registration
  In order to have my own farm management area
  As a farmer
  I need to be able to register

  Scenario: Register
    Given I am on "/register"
    When I fill in "Mail" with "farmer@gmail.com"
    And I fill in "Prénom" with "Jackie"
    And I fill in "Nom" with "Chan"
    And I fill in "Mot de passe" with "farmer"
    And I press "Créer un compte"
    Then I should be on "/register/confirmed"
