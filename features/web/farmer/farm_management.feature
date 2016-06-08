Feature: Farm management
  In order to manage information about my farm
  As a farmer
  I need to be able to edit my farm's information

  Background:
    Given I am logged in as a user with email "user@repair.nc" and password "user"

  Scenario: Create farm information
    When I am on "/farm/new"
    And I fill in "Nom de la ferme" with "Farm A"
    And I press "Enregistrer"
    Then I should see "Farm A"
    When I follow "Editer"
    And I fill in "Nom de la ferme" with "Farm B"
    And I press "Enregistrer"
    Then I should see "Farm B"


