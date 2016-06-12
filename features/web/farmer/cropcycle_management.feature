Feature: Crop Cycle Management
  In order to manage information about my crop cycles
  As a farmer
  I need to be able to create/edit/delete/show/list my crop cycles and see which one are actives

  Background:
    Given I am logged in as a farmer with email "farmer@repair.nc" and password "farmer"
    And I have a plot "Parcelle A"

  @clear_data
  Scenario: Create/Edit/Delete a crop cycle
    Given I should see "Parcelle A"
    And I follow "Ajouter une culture"
    And I fill in "Nom" with "Cycle 1"
    When I press "Enregistrer"
    Then I should see "Cycle 1"
    When I follow "Editer"
    And I fill in "Nom" with "Cycle 2"
    When I press "Enregistrer"
    Then I should see "Cycle 2"
    When I follow "Editer"
    When I press "Supprimer"
    Then I should not see "Cycle 2"


