Feature: List Farms
  In order to help farmers
  As an admin
  I need to access their data

  Background:
    Given I am logged in as an admin with email "admin@repair.nc" and password "admin"

  @admin_fixtures
  Scenario: List all farms
    Given I am on "admin/farm/list"
    Then I should see "Liste des exploitations"

  @admin_fixtures
  Scenario: Show a single farm data
    Given I am on "admin/farm/list"
    When I follow "Farm 1"
    Then I should see "Nom de la ferme"