@extends('layouts.admin.base')

@section("content")
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <div>
            <h3 class="text-primary">
                Voucher Card
            </h3>
        </div>
    </div>
    <div class="col-md-7 align-center">
            <div class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route("dashboard")}}">Dashboard</a>
                </li>
                @if($card != null)
                    <li class="breadcrumb-item">
                        <a class="btn btn-primary btn-sm" href="{{route("loadCard")}}">Load Card</a>
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
                    @if ($card == null)
                        <div class="row">
                            <div class="col-md-4 mx-auto">
                            <form action="{{route("generateVoucherCard", $passenger->passengerId)}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-block">Generate Card</button>
                            </form>
                            </div>
                        </div>
                    @else 
                        <div class="">
                            <div class="col-md-6">
                                <h4><b>Passenger:</b> {{$card->passenger->name}}</h4>
                            </div>
                            <div class="col-md-6">
                            <h4><b>Card Number:</b> {{$card->voucherNumber}}</h4>
                            </div>
                            
                            <div class="col-md-6">
                            <h4><b>Balance</b>: R{{$card->balance}}</h4>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
    </div>
@endsection