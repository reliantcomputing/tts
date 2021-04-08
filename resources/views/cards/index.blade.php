@extends('layouts.admin.base')

@section("content")
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <div>
            <h3 class="text-primary">
                Cards
            </h3>
        </div>
    </div>
    <div class="col-md-7 align-center">
            <div class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route("dashboard")}}">Dashboard</a>
                </li>
                @if (Auth::user()->role->name == "ROLE_PASSENGER")
                    <li class="breadcrumb-item">
                        <a href="{{route("createCard")}}">Add Card</a>
                    </li>                    
                @endif
            </div>
        </div>
    </div>
    <div class="container">
            @include('layouts.messages.message')
        </div>
    <div class="container">
            
            <div class="card mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th><b>Bank Name</b></th>
                                    <th><b>Card Owner</b></th>
                                    <th><b>Card Number</b></th>
                                    <th><b>balance</b></th>
                                    @if (Auth::user()->role->name == "ROLE_PASSENGER")
                                        <th><b>Action</b></th>                                        
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($cards as $card)
                                    <tr>
                                        <td>{{$card->bankName}}</td>
                                        <td>{{$card->cardOwner}}</td>
                                        <td>{{$card->cardNumber}}</td>
                                        <td>R{{$card->balance}}</td>
                                        @if (Auth::user()->role->name == "ROLE_PASSENGER")
                                            <td>
                                                <form action="{{route('deleteCard', $card->cardId)}}" method="POST">
                                                    @csrf
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this card: {{$card->cardId}}?');">Delete</button>
                                                </form>
                                            </td>                                            
                                        @endif
                                    </tr>
                                @endforeach
                                    
                                </tbody>
                            </table>
                        </div>

                </div>
            </div>
    </div>
@endsection