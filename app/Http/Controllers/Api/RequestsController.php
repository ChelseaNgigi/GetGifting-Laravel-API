<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DonationRequest;
use Illuminate\Support\Facades\Auth;


class RequestsController extends Controller
{
    public function request(Request $request){
        $donationRequest=DonationRequest::where('donation_id',$request->id)->where('user_id',Auth::user()->id)->get();

        //Check if it returns 0 - donation not yet requested else requested
        if(count($donationRequest)>0){
            $donationRequest[0]->delete();
            return response()->json([
                'success'=>true,
                'message'=>'Donation request removed'
            ]);
        }
        $donationRequest=new DonationRequest;
        $donationRequest->user_id=Auth::user()->id;
        $donationRequest->donation_id=$request->id;
        $donationRequest->save();

        return response()->json([
            'success'=>true,
            'message'=>'Donation request made'
        ]);
    }
}
