Feature: Farm management
  In order to manage information about my farm
  As a farmer
  I need to be able to edit my farm's information

  Background:
    Given I am logged in as a farmer with email "farmer@repair.nc" and password "farmer"

  Scenario: Create farm information
    When I am on "/farm/new"
    And print last response
    And I fill in "Nom de la ferme" with "MyFarm"
    And I press "Create"
    Then I should see "MyFarm"

  Scenario: Edit farm information
    When I am on "/farm/edit"
    And I fill in "Nom de la ferme" with "Agronomik"
    And I press "Enregistrer"
    Then I should be on "/farm"
    And I should see "Agronomik"


