<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Property;
use App\Models\ContactAgent;
use App\Models\ContactMessage;
use App\Models\PropertyListingType;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeLandController extends Controller
{
    public function index(Request $request){
        $query = Property::query();

        // Aqui se filtra por tipo de propiedad
        if ($request->has('listing_type') && $request->listing_type != '') {
            $query->where('property_listing_type_id', $request->listing_type);
        }

        // Aqui se filtra por tipo de oferta
        if ($request->has('offer_type') && $request->offer_type != '') {
            $query->where('offer_type', $request->offer_type);
        }

        // Aqui se filtra por ciudad
        if ($request->has('city') && $request->city != '') {
            $query->where('city_id', $request->city);
        }

        // Se obtieenen los datos filtrados
        $properties = $query->get();

        // opciones para los filtros
        $listingTypes = PropertyListingType::all();
        $cities = City::all();

        // Pasamos los datos a la vista
        return view('homeland.index', compact('properties', 'listingTypes', 'cities'));
    }

    public function property_details(Request $request, $property_id) {
        // Buscar la propiedad con sus reseñas
        $property = Property::with('reviews')->findOrFail($property_id);

        // Si la solicitud es POST, verificamos si viene del formulario de contacto o del formulario de reseñas
        if ($request->isMethod("POST")) {

            // Formulario de contacto
            if ($request->has('email')) {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|max:50',
                    'phone' => 'required|max:20|regex:/^[0-9+\-() ]+$/',
                    'message' => 'required|string|max:1000',
                ],[
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

                return redirect()->back()->with('success', 'Your message has been sent successfully.');
            }

            // Formulario de reseñas
            if ($request->has('rating')) {
                $request->validate([
                    'name' => 'required|string|max:100',
                    'comment' => 'required|string|max:1000',
                    'rating' => 'required|integer|min:1|max:5',
                ]);

                Review::create([
                    'property_id' => $property_id,
                    'name' => $request->input('name'),
                    'comment' => $request->input('comment'),
                    'rating' => $request->input('rating'),
                ]);

                return redirect()->back()->with('success', 'Review added successfully!');
            }
        }

        return view('homeland.property_details', compact('property'));
    }


    public function contact(){
        return view('homeland.contact');
    }
    public function about(){
        return view('homeland.about');
    }
    public function buy(Request $request){
        $query = Property::where("offer_type", "For Sale");

        if ($request->has('listing_type') && $request->listing_type != '') {
            $query->where('property_listing_type_id', $request->listing_type);
        }

        if ($request->has('city') && $request->city != '') {
            $query->where('city_id', $request->city);
        }

        // Obtener resultados filtrados
        $properties = $query->get();
        $listingTypes = PropertyListingType::all();
        $cities = City::all();

        return view('homeland.buy', compact('properties', 'listingTypes', 'cities'));
    }

    public function rent(Request $request){
        $query = Property::where("offer_type", "For Rent");

        if ($request->has('listing_type') && $request->listing_type != '') {
            $query->where('property_listing_type_id', $request->listing_type);
        }

        if ($request->has('city') && $request->city != '') {
            $query->where('city_id', $request->city);
        }

        // Obtener resultados filtrados
        $properties = $query->get();
        $listingTypes = PropertyListingType::all();
        $cities = City::all();

        return view('homeland.rent', compact('properties', 'listingTypes', 'cities'));
    }

    public function properties_listing_type($property_listing_type_id){
        //$properties = Property::where("property_listing_type", $listing_type_id);
        $properties = PropertyListingType::find($property_listing_type_id)->properties;
        //dd($properties);
        return view('homeland.index', compact('properties'));
    }
    public function register(){
        return view('homeland.register');
    }
    public function login(){
        return view('homeland.login');
    }

    public function sendContactMessage(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Guardar el mensaje en la base de datos
        $message = ContactMessage::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);

        // Enviar el correo electrónico
        Mail::send('homeland.contact', ['messageData' => $message], function ($mail) use ($message) {
            $mail->to('21030090@itcelaya.edu.mx')
                 ->subject($message->subject)
                 ->from($message->email, $message->name);
        });

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

}
