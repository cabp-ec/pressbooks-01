@search
Feature: SEARCH
  In order to get a list of books
  As a Consumer
  I need to be able to search for one or several books

  Scenario: Search for books
    Given Page limit is 1
    And Requested page is 1
    When Consumer requests all books
    Then Consumer gets a 200 response
    And There should be 2 total results
    And There should be 2 pages
    And Page 1 should have 1 results
