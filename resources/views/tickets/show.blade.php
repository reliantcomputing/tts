@extends('layouts.admin.base')


@section('content')

<div class="container">
        <div class="row pt-5">
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
                        {{$ticket->price}}
                    </div>
                    <div class="col-md-12">
                        <b>Departure Time: </b>
                        {{$train->departureTime}}
                    </div>
                    <div class="col-md-12">
                            <b>Bought: </b>
                            {{$ticket->created_at}}
                    </div>
            </div>
            <a class="btn btn-primary btn-sm" href="{{route("printTicket", $ticket->ticketId)}}">
                Download
            </a>
</div>
  
@endsection