<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\ContactAgent;
use App\Models\PropertyListingType;
use Illuminate\Http\Request;

class HomeLandController extends Controller
{
    public function index(){
        $properties = Property::all();
        return view('homeland.index', compact('properties'));
    }
    public function property_details(Request $request, $property_id){

        if($request->isMethod("POST")){

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:50',
                'phone' => 'required|max:20|regex:/^[0-9+\-() ]+$/',
                'message' => 'required|string|max:1000',
            ],[
                //No son necesarios pero se pueden personalizar mensajes al gusto
                'name.required' => 'The name field is required.',
                'email.required' => 'The email field is required.',
                'email.email' => 'The email must be a valid email address.',
                'phone.regex' => 'The phone number format is invalid.',
                'message.required' => 'The message field is required.',

            ]);

            $contact = new ContactAgent();
            $contact->name = $request->input('name');
            $contact->email = $request->input('email');
            $contact->phone = $request->input('phone');
            $contact->message = $request->input('message');
            $contact->save();
            session()->now('messaege', 'Your message has been sent sucessfuully');
        }

        $property = Property::find($property_id);
        return view('homeland.property_details', compact('property'));
    }
    public function contact(){
        return view('homeland.contact');
    }
    public function about(){
        return view('homeland.about');
    }
    public function buy(){
        $properties = Property::where("offer_type", "For Sale")->get();
        return view('homeland.buy');
    }
    public function rent(){
        $properties = Property::where("offer_type", "For Rent")->get();
        return view('homeland.rent');
    }
    public function properties_listing_type($property_listing_type_id){
        //$properties = Property::where("property_listing_type", $listing_type_id);
        $properties = PropertyListingType::find($property_listing_type_id)->properties;
        //dd($properties);
        return view('homeland.index', compact('properties'));
    }
}
