<?php

namespace App;
use App\Donation;
use App\User;

use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function donation(){
        return $this->belongsTo(Donation::class);
    }
}
