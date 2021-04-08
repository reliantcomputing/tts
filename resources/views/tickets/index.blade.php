@extends('layouts.admin.base')

@section("content")
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <div>
                <h3 class="text-primary">
                    Tickets

                    @if (Auth::user()->role->name == "ROLE_ADMIN")
                        <a class="btn btn-primary btn-sm" href="{{route("printTickets")}}">
                            Print All Tickets
                        </a>
                    @endif
                </h3>
            </div>
        </div>
        <div class="col-md-7 align-center">
                <div class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route("dashboard")}}">Home</a>
                    </li>
                    @if (Auth::user()->role->name == "ROLE_PASSENGER")
                        <li class="breadcrumb-item">
                            <a href="{{route("createTicket")}}">Book Ticket</a>
                        </li>                        
                    @endif
                </div>
            </div>
        </div>
        <div class="container">
                @include('layouts.messages.message')
            </div>
    <div class="container">
        @if (Auth::user()->role->name != "ROLE_ADMIN")
        @endif
            
            <div class="card mb-3">
                <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th><b>Trip</b></th>
                                    <th><b>Price</b></th>
                                    <th><b>Action</b></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>{{$ticket->trip}}</td>
                                        <td>R{{$ticket->price}}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{route("printTicket", $ticket->ticketId)}}">
                                                Get Ticket
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                    
                                </tbody>
                            </table>
                        </div>

                </div>
            </div>
    </div>
@endsection