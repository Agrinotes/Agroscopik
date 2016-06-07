Feature: Farm management
  In order to manage information about my farm
  As a farmer
  I need to be able to edit my farm's information

  Background:

  Scenario: Create and edit farm information
    Given I am logged in as a farmer with email "farmer@repair.nc" and password "farmer"
    When I am on "/farm/new"
    And I fill in "Nom de la ferme" with "MyFarm"
    And I press "Create"
    Then I should see "MyFarm"
    When I follow "Editer"
    And I fill in "Nom de la ferme" with "Agronomik"
    And I press "Enregistrer"
    Then I should see "Agronomik"


