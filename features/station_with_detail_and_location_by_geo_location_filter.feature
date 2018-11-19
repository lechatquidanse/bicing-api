Feature: Geo-locate the station for your next itinerary
  In order to plan where i will take a bike for my next itinerary
  As a client software API
  I need to be able to retrieve a list of nearby stations

  @database
  Scenario: Can Retrieve station list with their details and location filtered by Geo location queries.
    Given a list of station:
      | stationId                            | name                      | type          | address                | addressNumber | zipCode | latitude  | longitude |
      | 15cff96c-de06-4606-9870-b82eb9219339 | 50 - AV. PARAL.LEL, 54    | BIKE          | 50 - AV. PARAL.LEL, 54 | 2             | 08001   | 41.375    | 2.17035   |
      | 374c5b80-cb51-46d8-8f7d-48bce9044f23 | 114 - PL. JEAN GENET, 1   | ELECTRIC_BIKE | Av. Paral.lel          | 8-9           | 08001   | 41.376801 | 2.173039  |
      | 02ec1e88-4c3d-4b3d-af0a-0d11eb4ce1ab | 352 - C/RADI, 10/GRAN VIA | BIKE          | Radi                   | 8-9           | 08098   | 41.36335  | 2.134144  |
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/stations/near-by?latitude=41.373&longitude=2.17031&limit=800.00"
    Then the response status code should be 200
    And the JSON should be equal to:
    """
    {
      "@context": "/api/contexts/station",
      "@id": "/api/stations",
      "@type": "hydra:Collection",
      "hydra:member": [
        {
          "@id": "/api/stations/15cff96c-de06-4606-9870-b82eb9219339",
          "@type": "station",
          "id": "15cff96c-de06-4606-9870-b82eb9219339",
          "name": "50 - AV. PARAL.LEL, 54",
          "type": "BIKE",
          "address": "50 - AV. PARAL.LEL, 54",
          "addressNumber": "2",
          "zipCode": "08001",
          "latitude": 41.375,
          "longitude": 2.17035
        },
        {
          "@id": "/api/stations/374c5b80-cb51-46d8-8f7d-48bce9044f23",
          "@type": "station",
          "id": "374c5b80-cb51-46d8-8f7d-48bce9044f23",
          "name": "114 - PL. JEAN GENET, 1",
          "type": "ELECTRIC_BIKE",
          "address": "Av. Paral.lel",
          "addressNumber": "8-9",
          "zipCode": "08001",
          "latitude": 41.376801,
          "longitude": 2.173039
        }
      ],
      "hydra:view": {
          "@id": "/api/stations/near-by?latitude=41.373&longitude=2.17031&limit=800.00",
          "@type": "hydra:PartialCollectionView"
      }
    }
    """

  @database
  Scenario: Can't Retrieve station list with their details and location with bad query parameters
    Given a list of station:
      | stationId                            | name                      | type          | address                | addressNumber | zipCode | latitude  | longitude |
      | 15cff96c-de06-4606-9870-b82eb9219339 | 50 - AV. PARAL.LEL, 54    | BIKE          | 50 - AV. PARAL.LEL, 54 | 2             | 08001   | 41.375    | 2.17035   |
    When I add "Accept" header equal to "application/ld+json"
    And I send a "GET" request to "/api/stations/near-by?latitude=bad_query_type&longitude=2.17031&limit=800.00"
    Then the response status code should be 400
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json; charset=utf-8"
