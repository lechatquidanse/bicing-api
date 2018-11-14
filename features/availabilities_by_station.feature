# The availabilities (number of bike available and number of slot available).
# The "THEN" feature is more technical that it should be, because the output render a date that can't be mock for now in the test.
Feature: Plan my itinerary that requires a station according to its past statistics availabilities
  In order to plan my itinerary
  As a client software API
  I need to be able to retrieve availabilities of the station at a specific date

  @database
  Scenario: Can Retrieve stations's availabilities from last week in 2 hours period with a 5 minute interval as a default behaviour
    Given station identified by "15cff96c-de06-4606-9870-b82eb9219339" with station states from "last week":
      | stated_at             | available_bike | available_slot | status |
      | -55 minutes 1 seconds | 7              | 23             | OPENED |
      | -55 minutes           | 2              | 28             | OPENED |
      | +5 minutes            | 27             | 3              | OPENED |
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/stations/15cff96c-de06-4606-9870-b82eb9219339/availabilities"
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
  Scenario: Can Retrieve stations's availabilities for an interval in a period of time
    Given station identified by "15cff96c-de06-4606-9870-b82eb9219339" with station states from "2016-08-13 15:35:12":
      | stated_at             | available_bike | available_slot | status |
      | -55 minutes 1 seconds | 7              | 23             | OPENED |
      | -55 minutes           | 2              | 28             | OPENED |
      | +5 minutes            | 27             | 3              | OPENED |
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/stations/15cff96c-de06-4606-9870-b82eb9219339/availabilities?periodStart=2016-08-13 14:35:23&periodEnd=2016-08-13 16:35:23&interval=5 minute"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON should be equal to:
    """
      {
        "@context": "/api/contexts/collection%20of%20availabilities%20by%20time%20interval%20for%20a%20station",
        "@id": "/api/stations/15cff96c-de06-4606-9870-b82eb9219339/availabilities",
        "@type": "collection of availabilities by time interval for a station",
        "stationId": "15cff96c-de06-4606-9870-b82eb9219339",
        "availabilities": [
          {
            "interval": "2016-08-13 14:40:00",
            "available_bike_avg": "4.5000000000000000",
            "available_bike_min": 2,
            "available_bike_max": 7,
            "available_slot_avg": "25.5000000000000000",
            "available_slot_min": 23,
            "available_slot_max": 28
          },
          {
            "interval": "2016-08-13 15:40:00",
            "available_bike_avg": "27.0000000000000000",
            "available_bike_min": 27,
            "available_bike_max": 27,
            "available_slot_avg": "3.0000000000000000",
            "available_slot_min": 3,
            "available_slot_max": 3
          }
        ],
        "filter": {
            "periodStart": "2016-08-13 14:35:23",
            "periodEnd": "2016-08-13 16:35:23",
            "interval": "5 minute"
        }
      }
    """

  @database
  Scenario: Can't Retrieve last week availabilities from a station that does not exist
    Given station identified by "15cff96c-de06-4606-9870-b82eb9219339" with station states from "last week":
      | stated_at             | available_bike | available_slot | status |
      | -55 minutes 1 seconds | 7              | 23             | OPENED |
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/stations/feb78515-1b8b-42fa-b8f4-da8f80b44733/availabilities"
    Then the response status code should be 404
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"

  @database
  Scenario: Can't Retrieve last week availabilities from a station with bad query parameters
    Given station identified by "15cff96c-de06-4606-9870-b82eb9219339" with station states from "last week":
      | stated_at             | available_bike | available_slot | status |
      | -55 minutes 1 seconds | 7              | 23             | OPENED |
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/stations/15cff96c-de06-4606-9870-b82eb9219339/availabilities?periodStart=bad_parameters&periodEnd=bad_parameters&interval=bad_interval"
    Then the response status code should be 400
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
