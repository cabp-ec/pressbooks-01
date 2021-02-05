@welcome
Feature: WELCOME
  In order to get a welcome message
  As a Consumer
  I need to be able to visit the base endpoint

  Scenario: Asking for welcome message
    When Consumer performs a GET request to "/"
    Then Consumer gets a 200 response
