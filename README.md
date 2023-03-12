# Bus Booking System

## Requirements

 1. Egypt's cities as stations [Cairo, Giza, AlFayyum, AlMinya, Asyut...]
 2. Predefined trips between 2 stations that cross over in-between stations.
    1. ex: Cairo to Asyut trip that crosses over AlFayyum -firstly- then AlMinya.
 3. Bus for each trip, each bus has 12 available seats to be booked by users, each seat has an unique id.
 4. Users can book an available trip seat.

## Design

```mermaid
erDiagram
    Trip ||--||Bus: ""
    Bus ||--|{ Seat: ""
    Trip ||--|{ Station: ""
    Reservation ||--|| Seat: ""
    Reservation ||--|| Trip: ""
    Reservation ||--|{ Station: ""
    Reservation ||--|| User: ""
```

### ERD

```mermaid
erDiagram

    BUS {
        int id
        string brand
    }
    
    SEAT {
        int id
        int bus_id
    }
    
    STATION {
        int id
        string name
    }
    
    TRIP {
        int bus_id
        array path
    }
    
    TRIP_STATION {
        int id
        int trip_id
        int station_id
        array path_to_destination
        int previous_id
    }
    
    TRIP_SEAT {
        int trip_id
        int seat_id
        array station_ids
    }
    
    RESERVATION {
        int id
        int seat_id
        int user_id
        int source_trip_station_id
        int destination_trip_station_id
    }
    
    BUS ||--|{ SEAT : contains
    TRIP ||--|{ TRIP_STATION : has
    STATION ||--|{ TRIP_STATION : has
    TRIP ||--|| BUS : using
    SEAT ||--|{ RESERVATION : has
    TRIP_SEAT ||--|{ TRIP : has
    TRIP_SEAT ||--|{ SEAT : has
    TRIP_STATION ||--|{ RESERVATION : source
    TRIP_STATION ||--|{ RESERVATION : destination

```

## Sequences

### get a list of trips that have available seats
```mermaid
sequenceDiagram
    autonumber
    participant a as app
    participant tc as Trip Controller
    participant ts as Trip Service
    participant ss as Seat service
    participant db as Database
    a->>tc: get list of trips [source_id, destination_id]
    tc->>ts: getMany [source_id, destination_id]
    ts->>db: trips that pass through [source_id, destination_id]
    db->>ts: trips
    ts->>ss: available seats [trip, source_id, destination_id]
    ss->>ss: getPathBetweenTwoStations [source_id, destination_id]
    ss->>ss: get seats available on these path
    ss->>ts: seats
    ts->>tc: trips that have available seats
    tc->>a: trips
```

### reserve a seat on a trip
```mermaid
sequenceDiagram
    autonumber
    participant a as app
    participant rc as Reservation Controller
    participant ts as Reservation Service
    participant ss as Seat service
    participant db as Database
    a->>rc: reserve a seat [trip, source_id, destination_id, seat_id]
    rc->>ts: create reservation [trip, source_id, destination_id, seat_id]
    ts->>ss: reserve seat on these stations [trip, source_id, destination_id, seat_id]
    ss->>ss: getPathBetweenTwoStations [source_id, destination_id]
    ss->>ss: add path to seat
    ts->>db: create reservation    
    rc->>a: done
```

### api documentation

#### get list of trips

- method: `GET`
- uri: `/api/trips?source_id=1&destination_id=2`
- header: `Bearer Token`

- response:
  ```json
  [
    {
        "id": 2,
        "bus": {
            "id": 2,
            "brand": "inventore"
        },
        "seats": [
            {
                "id": 13
            },
            {
                "id": 14
            },
            {
                "id": 15
            },
            {
                "id": 16
            },
            {
                "id": 17
            },
            {
                "id": 18
            },
            {
                "id": 19
            },
            {
                "id": 20
            },
            {
                "id": 21
            },
            {
                "id": 22
            },
            {
                "id": 23
            },
            {
                "id": 24
            }
        ]
    }
]


#### book a seat on a trip

- method: `POST`
- uri: `/api/trips/2/reservation`
- header: `Bearer Token`
- request:
  ```json
  {
     "source_id": 1,
     "destination_id": 2,
     "seat_id": 13
  }
  ```
- response:
  ```json
  "seat booked successfully"
  ```

#### login

- method: `POST`
- uri: `/api/login`
- request:
  ```json
  {
     "email": "admin@gmail.com",
     "password": "password"
  }
  ```
- response:
  ```json
    {
      "id": 1,
      "token": "4|g2MOB40k80T2uyATxNhZHv4pr4SokXtdAzZPnKZ4"
    }
  ```
  
### set up the environment
1. create MySql DB `bus_booking`.
2. create `.env` from `example.env`.
3. run command `composer install`.
4. run command `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`.
5. run command `php artisan migrate --seed`.
6. run command `php artisan serve`.
