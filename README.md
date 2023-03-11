# Bus Booking System

## Requirements

 1. Egypt's cities as stations [Cairo, Giza, AlFayyum, AlMinya, Asyut...]
 2. Predefined trips between 2 stations that cross over in-between stations.
    1. ex: Cairo to Asyut trip that crosses over AlFayyum -firstly- then AlMinya.
 3. Bus for each trip, each bus has 12 available seats to be booked by users, each seat has an unique id.
 4. Users can book an available trip seat.

## Design

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
    
    BOOKING {
        int id
        int seat_id
        int source_trip_station_id
        int destination_trip_station_id
    }
    
    BUS ||--|{ SEAT : contains
    TRIP ||--|{ TRIP_STATION : has
    STATION ||--|{ TRIP_STATION : has
    TRIP ||--|| BUS : using
    SEAT ||--|{ BOOKING : has
    TRIP_SEAT ||--|{ TRIP : has
    TRIP_SEAT ||--|{ SEAT : has
    TRIP_STATION ||--|{ BOOKING : source
    TRIP_STATION ||--|{ BOOKING : destination
    TRIP_STATION ||--|| TRIP_STATION : next

```