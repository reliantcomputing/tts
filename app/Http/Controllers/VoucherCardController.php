<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Passenger;
use App\VoucherCard;
use App\Card;

class VoucherCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
    }

    public function index()
    {
        $userId = Auth::user()->userId;
        $passenger = Passenger::where("userId", $userId)->first();
        $voucherCard = VoucherCard::where("passengerId", $passenger->passengerId)->first();
        return view("voucher.card", ["card" => $voucherCard, "passenger" => $passenger]);
    }

    public function generate($id){
        if (!Passenger::where("passengerId", $id)->first()) {
            return redirect()->back()->with("error", "Passenger not found");
        }
        $passenger = Passenger::where("passengerId", $id)->first();

        if ($passenger->voucherCard != null) {
            return redirect()->back()->with("error", "Voucher card already exist.");
        }

        $card = new VoucherCard;
        $card->balance = 0.0;
        $card->voucherNumber = rand(1111111111111111, 9999999999999999);
        $card->passengerId = $passenger->passengerId;

        $card->save();
        return redirect()->route('voucherCard')->with("success", "Card generated successfully.");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function load()
    {
        $userId = Auth::user()->userId;

        $passenger = Passenger::where("userId", $userId)->first();
        $cards = Card::where("passengerId", $passenger->passengerId)->get();
        return view("cards.loadMoney", ["cards" => $cards]);
    }

    public function cardMoney(Request $request)
    {
        $this->validate($request, [
            "amount" => "required",
            "bankCard" => "required"
        ]);
        $userId = Auth::user()->userId;

        $passenger = Passenger::where("userId", $userId)->first();
        $card = Card::where("cardId", $request->bankCard)->first();
        $card->balance = $card->balance - $request->amount;
        if($card->balance < 0){
            return redirect()->back()->with("error", "Insufficient funds");
        }

        $card->update();
        $voucherCard = VoucherCard::where("passengerId", $passenger->passengerId)->first();

        $voucherCard->balance = $voucherCard->balance + $request->amount;
        $voucherCard->update();
        return redirect()->route('voucherCard')->with("success", "Card loaded successfully.");
    }
}
