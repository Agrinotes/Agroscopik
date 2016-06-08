Feature: Authentication
  In order to gain access to my farm management area
  As a farmer
  I need to be able to login and logout

  Background:
    Given there is a user with email "farmer@repair.nc" and password "farmer"

  Scenario: Logging in
    Given I am on "/login"
    When I fill in "E-mail" with "farmer@repair.nc"
    And I fill in "Mot de passe" with "farmer"
    And I press "Se connecter"
    Then I should see "Connecté"

  Scenario: Logging in with bad credentials
    Given I am on "/login"
    When I fill in "E-mail" with "farmer@repair.nc"
    And I fill in "Mot de passe" with "wrong_password"
    And I press "Se connecter"
    Then I should see "Identifiants invalides"

