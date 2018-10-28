# The availability (status, number of bike available and number of slot available).
Feature: View last availability for each stations to choose one to start or end my itinerary.
  In order to select a station
  As a client software API
  I need to be able to retrieve a list composed by the last availabilit for each stations.

  @database
  Scenario: Can retrieve last availability for each stations.
    Given station identified by "15cff96c-de06-4606-9870-b82eb9219339" with station states from "2018-09-17 15:52:51":
      | stated_at  | available_bike | available_slot | status |
      | -5 minutes | 2              | 28             | OPENED |
      | +5 minutes | 27             | 3              | CLOSED |
    And station identified by "2d55ba4e-e0b0-4145-aff5-96426aee669b" with station states from "2018-09-23 15:48:51":
      | stated_at  | available_bike | available_slot | status |
      | -2 minutes | 10             | 10             | OPENED |
      | +1 minutes | 18             | 2              | OPENED |
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/last-availabilities-by-station"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON should be equal to:
    """
      {
        "@context": "/api/contexts/last%20availability%20by%20station",
        "@id": "/api/last-availabilities-by-station",
        "@type": "hydra:Collection",
        "hydra:member": [
          {
            "@id": "/api/last-availabilities-by-station/15cff96c-de06-4606-9870-b82eb9219339",
            "@type": "last availability by station",
            "id": "15cff96c-de06-4606-9870-b82eb9219339",
            "statedAt": "2018-09-17T15:57:51+02:00",
            "availableBikeNumber": 27,
            "availableSlotNumber": 3,
            "status": "CLOSED"
          },
          {
            "@id": "/api/last-availabilities-by-station/2d55ba4e-e0b0-4145-aff5-96426aee669b",
            "@type": "last availability by station",
            "id": "2d55ba4e-e0b0-4145-aff5-96426aee669b",
            "statedAt": "2018-09-23T15:49:51+02:00",
            "availableBikeNumber": 18,
            "availableSlotNumber": 2,
            "status": "OPENED"
          }
        ]
      }
    """

  @database
  Scenario: Can retrieve last availability for a station that does not exists.
    Given station identified by "15cff96c-de06-4606-9870-b82eb9219339" with station states from "2018-09-17 15:52:51":
      | stated_at  | available_bike | available_slot | status |
      | -5 minutes | 2              | 28             | OPENED |
      | +5 minutes | 27             | 3              | CLOSED |
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/last-availabilities-by-station/15cff96c-de06-4606-9870-b82eb9219339"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
    And the JSON should be equal to:
    """
      {
        "@context": "/api/contexts/last%20availability%20by%20station",
        "@id": "/api/last-availabilities-by-station/15cff96c-de06-4606-9870-b82eb9219339",
        "@type": "last availability by station",
        "id": "15cff96c-de06-4606-9870-b82eb9219339",
        "statedAt": "2018-09-17T15:57:51+02:00",
        "availableBikeNumber": 27,
        "availableSlotNumber": 3,
        "status": "CLOSED"
      }
    """

  @database
  Scenario: Can not retrieve last availability for a station that does not exists.
    Given station identified by "15cff96c-de06-4606-9870-b82eb9219339" with station states from "2018-09-17 15:52:51":
      | stated_at  | available_bike | available_slot | status |
      | -5 minutes | 2              | 28             | OPENED |
      | +5 minutes | 27             | 3              | CLOSED |
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/last-availabilities-by-station/2d55ba4e-e0b0-4145-aff5-96426aee669b"
    Then the response status code should be 404
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
