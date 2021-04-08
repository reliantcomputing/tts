@extends('layouts.admin.base')


@section('content')

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <div>
            <h3 class="text-primary">
                Load Your Voucher Card
            </h3>
        </div>
    </div>
    <div class="col-md-7 align-center">
            <div class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route("dashboard")}}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{route("stations")}}">Back</a>
                </li>
            </div>
        </div>
    </div>
    <div class="container">
            @include('layouts.messages.message')
        </div>    
<div class="container mt-4 pb-5">
        <!-- Table -->
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card bg-white shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" method="POST" action="{{ route('saveCardMoney') }}">
                            @csrf()
                            
                            <!-- first name and last name -->

                            <div class="row">
                                    <div class="col-md-12">
                                            <div class="form-group{{ $errors->has('bankCard') ? ' has-danger' : '' }}">
                                                <label for="description">
                                                    <b>Bank Card
                                                        <span class="text-danger">*</span>
                                                    </b>
                                                </label>
                                                <div class="input-group input-group-alternative mb-3">
                                                    <select class="form-control{{ $errors->has('bankCard') ? ' is-invalid' : '' }}" name="bankCard">
                                                        @foreach ($cards as $card)
                                                            <option value="{{$card->cardId}}">{{$card->bankName}} - {{$card->cardNumber}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @if ($errors->has('bankCard'))
                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong>{{ $errors->first('bankCard') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                            <label for="description">
                                                <b>Amount
                                                     <span class="text-danger">*</span>
                                                </b>
                                            </label>
                                            <div class="input-group input-group-alternative mb-3">
                                                <input class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" type="text" name="amount" value="{{ old('amount') }}" required autofocus>
                                            </div>
                                            @if ($errors->has('amount'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
    
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Load Amount') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
