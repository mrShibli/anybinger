<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\TravelerProduct;
use Illuminate\Http\Request;

class TravelerDashController extends Controller
{
    public function index(){
        $data = TravelerProduct::all();
        
        return view('client.travelerDashboard', compact('data'));
    }
}
