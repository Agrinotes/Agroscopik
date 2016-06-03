Feature: Authentication
  In order to gain access to my farm management area
  As a farmer
  I need to be able to login and logout

  Scenario: Logging in
    Given there is a farmer user with email "farmer@gmail.com" and password "farmer"
    And I am on "/login"
    When I fill in "Mail" with "farmer@gmail.com"
    And I fill in "Mot de passe" with "farmer"
    And I press "Connexion"
    Then I should see "Déconnexion"
