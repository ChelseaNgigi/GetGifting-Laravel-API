<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Donation;
use Illuminate\Support\Facades\Auth;

class DonationsController extends Controller
{
    public function create(Request $request){
        $donation=new Donation;
        $donation->user_id=Auth::user()->id;
        $donation->typeOfFood=$request->typeOfFood;
        $donation->quantity=$request->quantity;
        $donation->location=$request->location;
        $donation->description=$request->description;

        //Check if the food being donated has a photo
        if($request->photo !=''){
            //Choose unique name for the photo
            $photo=time().'jpg';
            //Link storage folder to public
            file_put_contents('storage/donations/'.$photo,base64_decode($request->photo));
            $donation->photo=$photo;
     }
        $donation->save();
        $donation->user;
        return response()->json([
            'success'=>true,
            'message'=>'Donated',
            'donation'=>$donation
        ]);
        
    }
    public function update(Request $request){
        $donation=Donation::find($request->id);
        //$donation->user_id=$request->user_id;
        //Check if user is editing his own donation
        if(Auth::user()->id != $donation->user_id){
            return response()->json([
                'success'=>false,
                'message'=>'Unauthorized access'
            ]);
        }
        $donation->typeOfFood=$request->typeOfFood;
        $donation->quantity=$request->quantity;
        $donation->location=$request->location;
        $donation->description=$request->description;
        if($request->photo !=''){
            //Choose unique name for the photo
            $photo=time().'jpg';
            //Link storage folder to public
            file_put_contents('storage/donations/'.$photo,base64_decode($request->photo));
            $donation->photo=$photo;
        }
        $donation->update();
        return response()->json([
            'success'=>true,
            'message'=>'Donation edited'
        ]);

    }

    public function delete(Request $request){
        $donation=Donation::find($request->id);
       // $donation->user_id=$request->user_id;
        //Check if user is editing his own donation
        if(Auth::user()->id != $donation->user_id){
            return response()->json([
                'success'=>false,
                'message'=>'Unauthorized access'
            ]);
        }
        //Check if donation has photo to delete
        if($donation->photo !=''){
            Storage::delete('public/donations'.$donation->photo);
        }
        $donation->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Donation deleted'
        ]);

    }
    public function donations(){
        $donations=Donation::orderBy('id','desc')->get();
        foreach($donations as $donation){
            //get user of the post
            $donation->user;
            //Requests count
            $donation['requestCount']=count($donation->requests);
            //check if user requested his own donation
            $donation['selfDonationRequest']= false;
            foreach($donation->requests as $request){
                if($request->user_id == Auth::user()->id){
                    $donation['selfDonationRequest'] = true;
                }
            }
        }
        return response()->json([
            'success'=>true,
            'donations'=>$donations
        ]);
    }
    public function myDonations(){
        $donations=Donation::where('user_id',Auth::user()->id)->orderBy('id','desc')->get();
        $user=Auth::user();
        foreach($donations as $donation){
            $donation['requestCount']=count($donation->requests);
        }
        return response()->json([
            'success'=>true,
            'donations'=>$donations,
            'user'=>$user
        ]);
    }
    public function myRequests(){
        $donations=Donation::has($donation->requests,'>=',1)->orderBy('id','desc')->get();
        $user=Auth::user();
        foreach($donations as $donation){
            $donation['requestCount']=count($donation->requests);
        }
        return response()->json([
            'success'=>true,
           'donations'=>$donations,
            'user'=>$user
        ]);
    }
}
