<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Station;
use App\Train;
use App\Passenger;
use App\Price;
use App\Card;
use App\VoucherCard;

use Auth;
use PDF;

class TicketController extends Controller
{
    private $centurion = "Centurion";
    private $johannesburg = "Johannesburg";
    private $pretoria = "Pretoria";
    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = null;
        
        if (Auth::user()->role->name == "ROLE_ADMIN") {
            $tickets = Ticket::all();
        }else {
            $userId = Auth::user()->userId;
            $passenger = Passenger::where("userId", $userId)->first();
            $tickets = Ticket::where("passengerId", $passenger->passengerId)->get();
        }
        
        return view("tickets.index", ["tickets" => $tickets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stations = Station::all();
        $trains = Train::all();
        $userId = Auth::user()->userId;
        $prices = Price::all();
        $trains = Train::where("isAvailable", true)->get();
        $passenger = Passenger::where("userId", $userId)->first();
        $cards = Card::where("passengerId", $passenger->passengerId)->get();
        return view("tickets.create", ["stations" => $stations, 
        "cards"=>$cards,
        "trains"=>$trains,
        "prices"=>$prices ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            "trip"=> "required",
        ]);

        //
        $ticket = new Ticket;
        $email = Auth::user()->email;
        $price = Price::where("priceId", $request->trip)->first();

        $userId = Auth::user()->userId;

        $passenger = Passenger::where("userId", $userId)->first();

        if (!VoucherCard::where("passengerId", $passenger->passengerId)->first()) {
            return redirect()->back()->with("error", "No voucher card, Click voucher card link, then followed by generate.");
        }

        $card = VoucherCard::where("passengerId", $passenger->passengerId)->first();

        if (!Passenger::where("passengerId", $passenger->passengerId)->first()) {
            return redirect()->back()->with("error", "Passenger not found");
        }

        

        //destination
        $origin = $price->from;
        $destination = $price->destination;

        //get the trip
        $stationOrigin = Station::where("name", $origin)->first();
        $stationDestination = Station::where("name", $destination)->first();

        $ticket->passengerId = $passenger->passengerId;
        $ticket->trip = $price->from." - ".$price->destination;
        if ($stationOrigin->stationNumber > $stationDestination->stationNumber) {
            if (!Train::where("origin", "Johannesburg")->first()) {
                    return redirect()->back()->with("error", "Train to your place is not availabe.");
            }
            $train = Train::where("origin", "Johannesburg")->first();
            if ($train->currentLoad > $train->maximumLoad) {
                return redirect()->back()->with("error", "Train $train->trainNumber is full.");
            }
            $ticket->trainId = $train->trainId;
            $train->currentLoad = $train->currentLoad + 1;
            $train->update();
        }else{
            if (!Train::where("origin", "Pretoria")->first()) {
                    return redirect()->back()->with("error", "Train to your place is not availabe.");
                
            }
            $train = Train::where("origin", "Pretoria")->first();
            if ($train->currentLoad > $train->maximumLoad) {
                return redirect()->back()->with("error", "Train $train->trainNumber is full.");
            }
            $ticket->trainId = $train->trainId;
            $train->currentLoad = $train->currentLoad + 1;
            $train->update();
        }

        //ticket price
        $ticket->price = $price->price;

        $card->balance = $card->balance - $ticket->price;
        if ($card->balance < 0) {
            return redirect()->back()->with("error", "Insufficient funds.");
        }
        //update
        $card->update();
        //save
        $ticket->save();
        return redirect()->route("tickets")->with("success", "Ticket booked successsfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Ticket::where("ticketId", $id)->first()) {
            return redirect()->route("tickets")->with("error", "Ticket not found!");
        }
        $ticket = Ticket::where("ticketId", $id)->first();
        $train = Train::where("trainId", $ticket->trainId)->first();

        return view("tickets.show", ["ticket"=>$ticket, "train"=>$train]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Ticket::where("roleId", $id)->first()) {
            return redirect()->route("tickets")->with("error", "Ticket not found!");
        }
        $ticket = Ticket::where("roleId", $id)->first();
        $stations = Station::all();
        $trains = Train::all();

        return view("tickets.edit", ["ticket"=>$ticket,
            "stations"=>$stations, "trains"=>$trains
        ]);
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
        $this->validate($request,[
            "train" => "required",
            "destination" => "required",
            "from"=>"required"
        ]);
        $ticket = Ticket::where("roleId", $id)->first();
        $email = Auth::user()->email;

        $ticket->train_id = $request->train;
        $ticket->destination = $request->destination;
        $ticket->from = $request->from;

        $ticket->update();
        return redirect()->route("tickets")->with("success", "Ticket updated successsfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Ticket::where("roleId", $id)->first()) {
            return redirect()->route("tickets")->with("error", "Ticket not found!");
        }
        $ticket = Ticket::where("roleId", $id)->first();
        $ticket->delete();
        return redirect()->route("tickets")->with("success", "Ticket deleted successsfully!");
    }

    public function unbook($id)
    {
        if (!Ticket::where("ticketId", $id)->first()) {
            return redirect()->route("tickets")->with("error", "Ticket not found!");
        }
        $ticket = Ticket::where("ticketId", $id)->first();
        $ticket->isBooked = false;
        $train = Train::where("trainId", $ticket->trainId)->first();
        $train->currentLoad = $train->currentLoad - 1;
        $ticket->update();
        return redirect()->route("tickets")->with("success", "Ticket deleted successsfully!");
    }

    public function rebook($id)
    {
        if (!Ticket::where("ticketId", $id)->first()) {
            return redirect()->route("tickets")->with("error", "Ticket not found!");
        }
        $ticket = Ticket::where("ticketId", $id)->first();
        $ticket->isBooked = true;
        $train = Train::where("trainId", $ticket->trainId)->first();
        $train->currentLoad = $train->currentLoad + 1;
        $ticket->update();
        return redirect()->route("tickets")->with("success", "Ticket deleted successsfully!");
    }


    public function generateTicket($id)
    {

        if (!Ticket::where("ticketId", $id)->first()) {
            return redirect()->route("tickets")->with("error", "Ticket not found!");
        }
        $ticket = Ticket::where("ticketId", $id)->first();
        $train = Train::where("trainId", $ticket->trainId)->first();

        $pdf = PDF::loadView("tickets.ticket", ["ticket"=>$ticket, "train" => $train]);

        return $pdf->download("$ticket->created_at ticket.pdf");
    }

    public function printTickets()
    {
        $tickets = Ticket::all();
        $pdf = PDF::loadView("tickets.all", ["tickets" => $tickets]);

        return $pdf->download("tickets.pdf");
    }
}
