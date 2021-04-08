
    <div class="row">
            <div class="col-md-4 mx-auto">
                <h3>All Ticket</h3>
            </div>
        </div>
        <div class="row">
            @foreach ($tickets as $ticket)
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
                        {{$ticket->getTrain($ticket->trainId)->departureTime}}
                    </div>
                    <div class="col-md-12">
                        <b>Passenger: </b>
                        {{$ticket->getUser($ticket->passengerId)->name}}
                    </div>
                    <div class="col-md-12">
                            <b>Bought: </b>
                            {{$ticket->created_at}}
                    </div>
                    <hr>
            @endforeach
                
        </div>