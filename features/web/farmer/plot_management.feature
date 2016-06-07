Feature: Plot management
  In order to manage information about my plots
  As a farmer
  I need to be able to create/show/edit/delete plots

  Scenario: Create a plot on current farm
    Given I am logged in as a farmer with email "farmer@repair.nc" and password "farmer"
    And I am on "/"
    When I follow "Parcelles"
    Then I should see "Vous n'avez pas encore enregistré de parcelle"
    When I press "Ajouter"
    Then I should be on "plot/new"
    And I fill in "Nom" with "Parcelle A"
    And I fill in "Surface" with "2"
    And I press "Enregister"
    Then I should see "Parcelle A"
    And I should see "2ha"
