Feature: Registration
  In order to have my own farm management area
  As a farmer
  I need to be able to register

  Scenario: Register
    Given I am on "/register"
    When I fill in "E-mail" with "farmer@repair.nc"
    And I fill in "Prénom" with "Hugo"
    And I fill in "Nom" with "Lehoux"
    And I fill in "Mot de passe" with "farmer"
    And I press "Créer un compte"
    Then I should be on "/register/confirmed"
    And I should have the role "ROLE_FARMER"