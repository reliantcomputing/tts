<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherCard extends Model
{
    protected $table = "voucher_card";
    protected $primaryKey = "voucherCardId";

    public function passenger()
    {
        return $this->belongsTo('App\Passenger', 'passengerId');
    }
}
