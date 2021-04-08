@extends('layouts.admin.base')

@section("content")
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <div>
            <h3 class="text-primary">
                Dashboard
            </h3>
        </div>
    </div>
    <div class="col-md-7 align-center">
            
    </div>
</div>
<div class="row">
    <div class="col-md-7 mx-auto">
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                      
                      @foreach ($trains as $key=>$train)
                      @if ($key == 0)
                            <div class="carousel-item active">
                                <span class="text-danger">
                                <b>Train {{$train->trainNumber}} will leave from {{$train->origin}} station to {{$train->destination}} station at {{$train->departureTime}}</b>
                                </span>
                            </div> 
                      @else
                            <div class="carousel-item">
                                <span class="text-danger">
                                <b>Train {{$train->trainNumber}} will leave from {{$train->origin}} station to {{$train->destination}} station at {{$train->departureTime}}</b>
                                </span>
                            </div>    
                      @endif
                        
                      @endforeach
                    </div>
                  </div>
    </div>
</div>

<div class="container">
    @include('layouts.messages.message')
</div>
<div class="container-fluid">
        <div class="row">
                <div class="col-md-3">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-train f-s-40 color-primary"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2>{{$trains->count()}}</h2>
                                <h5 class="m-b-0">
                                <a href="{{route("trains")}}">Trains</a>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->role->name == "ROLE_ADMIN")
                    <div class="col-md-3">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-users f-s-40 color-success"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2>{{$passengers->count()}}</h2>
                                    <h5 class="m-b-0">
                                    <a href="{{route("passengers")}}">Passengers</a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-3">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-train f-s-40 color-warning"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2>{{$stations->count()}}</h2>
                                <h5 class="m-b-0">
                                    <a href="{{route("stations")}}">Stations</a>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-ticket f-s-40 color-danger"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2>{{$tickets->count()}}</h2>
                                <h5 class="m-b-0">
                                    <a href="{{route("tickets")}}">Tickets</a>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->role->name == "ROLE_PASSENGER")
                    <div class="col-md-3">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-credit-card f-s-40 color-primary"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2>{{$cards->count()}}</h2>
                                    <h5 class="m-b-0">
                                    <a href="{{route("cards")}}">Cards</a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>                   
                @endif

                    @if (Auth::user()->role->name == "ROLE_ADMIN")
                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i class="fa fa-money f-s-40 color-success"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>{{$prices->count()}}</h2>
                                        <h5 class="m-b-0">
                                        <a href="{{route("prices")}}">Prices</a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
            </div>

            <div class="col-md-3">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-train f-s-40 color-primary"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                            
                                <h4 class="m-b-0">
                                <a href="{{route("track")}}">Track IT</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
</div>

@endsection