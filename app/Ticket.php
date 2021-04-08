<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Passenger;

class Ticket extends Model
{
    protected $table = "ticket";
    protected $primaryKey = "ticketId";
    public function passenger()
    {
        return $this->belongsTo('App\Passenger', "passengerId");
    }

    public function getUser($id){
        $passenger = Passenger::where("passengerId", $id)->first();
        return $passenger;
    }

    public function getTrain($id)
    {
        return Train::where("trainId", $id)->first();
    }

    public function train()
    {
        return $this->belongsTo('App\Train', "trainId");
    }
}
