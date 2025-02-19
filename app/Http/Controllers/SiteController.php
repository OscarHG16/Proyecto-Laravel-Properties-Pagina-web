<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class SiteController extends Controller
{
    public function index(){
        return view('index');
    }
    public function contact(){
        return view('contact');
    }
    public function services(){
        //Opcción 1
        //return view('services', ["var1"=>"value 1","var2"=>"value 2"]);

        //Opcción 2: cuando tenemos muchas variables usamos la función "compact" pero tiene el mismo efecto
        //que la opcción 1
        /*
        $var1 = "Hello";
        $var2 = "World";
        return view('services', compact('var1', 'var2'));
        */
        $services = Service::all();
        return view('services', compact('services'));

    }
    public function about(){
        return view('about');
    }
}
