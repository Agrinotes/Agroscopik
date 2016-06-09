Feature: Plot management
  In order to manage information about my plots
  As a farmer
  I need to be able to create/show/edit/delete plots

  Background:
    Given I am logged in as a farmer with email "farmer@repair.nc" and password "farmer"

  Scenario: Create, Show, Edit and delete a plot on current farm
    And I am on "plot/new"
    And I fill in "Nom" with "Parcelle A"
    When I press "Enregistrer"
    Then I should see "Parcelle A"
    And I follow "Editer"
    And I fill in "Nom" with "Parcelle B"
    When I press "Enregistrer"
    Then I should see "Parcelle B"
    And I should not see "Supprimer"
    When I follow "Editer"
    And I press "Supprimer"
    Then I should see "Liste des parcelles"
    And I should not see "Parcelle B"




