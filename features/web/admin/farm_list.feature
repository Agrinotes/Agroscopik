Feature: List Farms
  In order to help farmers
  As an admin
  I need to access their data

  Background:
    Given I am logged in as an admin with email "admin@repair.nc" and password "admin"

  @clear_data @load_admin_fixtures
  Scenario: List all farms
    Given I am on "farm/list"
    Then I should see "Liste des exploitations"
    And I should see "Farm 1"
    And I should see "farmer_first_name farmer_last_name"

  @clear_data @load_admin_fixtures
  Scenario: Show a single farm data
    Given I am on "farm/list"
    When I follow "Farm 1"
    Then I should see "Farm 1"
