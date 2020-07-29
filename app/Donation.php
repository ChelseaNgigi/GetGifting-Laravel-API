<?php

namespace App;

use App\DonationRequest;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function requests(){
        return $this->hasMany(DonationRequest::class);
    }
}
