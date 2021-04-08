
    <div class="row">
        <div class="col-md-4 mx-auto">
            <h3>Train Ticket</h3>
        </div>
    </div>
    <div class="row">
            <div class="col-md-12">
                <b>Trip: </b>
                {{$ticket->trip}}
            </div>
            <div class="col-md-12">
                <b>Price: </b>
                R{{$ticket->price}}
            </div>
            <div class="col-md-12">
                <b>Departure Time: </b>
                {{$ticket->getTrain($ticket->ticketId)->departureTime}}
            </div>
            <div class="col-md-12">
                <b>Passenger: </b>
                {{$ticket->getUser($ticket->ticketId)->email}}
            </div>
            <div class="col-md-12">
                    <b>Bought: </b>
                    {{$ticket->created_at}}
            </div>
    </div>