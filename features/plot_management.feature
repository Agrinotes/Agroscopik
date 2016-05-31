Feature: Plot management panel
  In order to manage plots on my farm
  As a farmer
  I need to be able to list/add/edit/delete plots

  Scenario: List plots from my farm
    Given I am on "/"
    When I follow "Parcelles"
    Then I should see "Parcelle A"
