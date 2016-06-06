Feature: Farm management panel
  In order to manage information about my farm
  As a farmer
  I need to be able to edit my farm's information

  Background:
    Given I am logged in as a farmer

  Scenario: Read farm information
    When I am on "/farm"
    And I should see "Nom de l'exploitation"

  Scenario: Edit farm information
    When I am on "farm"
    And I follow "Editer"
    And I fill in "Nom de l'exploitation" with "Agronomik"
    And I press "Enregistrer"
    Then I should be on "/farm"
    And I should see "Agronomik"


