Feature: Crop Cycle Management
  In order to manage information about my crop cycles
  As a farmer
  I need to be able to create/edit/delete/show/list my crop cycles and see which one are actives

  Background:
    Given I am logged in as a farmer with email "farmer@repair.nc" and password "farmer"
    And I have a plot "Parcelle A"

  Scenario: Create a crop cycle on current plot
    Given I should see "Parcelle A"
    And I press "Ajouter une culture"
    Then I should be on "cropcycle/new"
    And I select "Tomate" from "Culture(s)"
    And I check "Sur toute la surface de la parcelle"
    When I press "Enregistrer"
    Then I should see "Vous pouvez commencer à ajouter des interventions"
