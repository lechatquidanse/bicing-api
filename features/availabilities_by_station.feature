# The availabilities (number of bike available and number of slot available).
# The "THEN" feature is more technical that it should be, because the output render a date that can't be mock for now in the test.
Feature: Plan my itinerary that requires a station according to its past statistics availabilities
  In order to plan my itinerary
  As a client software API
  I need to be able to retrieve availabilities of the station at a specific date

  @database
  Scenario: Can Retrieve last week availabilities from a station
    Given station identified by "15cff96c-de06-4606-9870-b82eb9219339" with station states from "last week":
      | stated_at             | available_bike | available_slot | status |
      | -55 minutes 1 seconds | 7              | 23             | OPENED |
      | -55 minutes           | 2              | 28             | OPENED |
      | +5 minutes            | 27             | 3              | OPENED |
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/availabilities/15cff96c-de06-4606-9870-b82eb9219339"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON node "root.stationId" should exist
    And the JSON node "stationId" should be equal to "15cff96c-de06-4606-9870-b82eb9219339"
    And the JSON node "root.availabilities" should exist
    And the JSON node "availabilities" should have 2 elements
    And the JSON node "availabilities[0].available_bike_avg" should be equal to "4.5000000000000000"
    And the JSON node "availabilities[0].available_bike_min" should be equal to 2
    And the JSON node "availabilities[0].available_bike_max" should be equal to 7
    And the JSON node "availabilities[0].available_slot_avg" should be equal to "25.5000000000000000"
    And the JSON node "availabilities[0].available_slot_min" should be equal to 23
    And the JSON node "availabilities[0].available_slot_max" should be equal to 28
    And the JSON node "availabilities[1].available_bike_avg" should be equal to "27.0000000000000000"
    And the JSON node "availabilities[1].available_bike_min" should be equal to 27
    And the JSON node "availabilities[1].available_bike_max" should be equal to 27
    And the JSON node "availabilities[1].available_slot_avg" should be equal to "3.0000000000000000"
    And the JSON node "availabilities[1].available_slot_min" should be equal to 3
    And the JSON node "availabilities[1].available_slot_max" should be equal to 3

  @database
  Scenario: Can't Retrieve last week availabilities from a station that does not exist
    Given station identified by "15cff96c-de06-4606-9870-b82eb9219339" with station states from "last week":
      | stated_at             | available_bike | available_slot | status |
      | -55 minutes 1 seconds | 7              | 23             | OPENED |
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/availabilities/feb78515-1b8b-42fa-b8f4-da8f80b44733"
    Then the response status code should be 404
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
