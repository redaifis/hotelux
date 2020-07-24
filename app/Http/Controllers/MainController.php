<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{

    public function landingPage(){
        return view('app.landingPage');
    }
}
