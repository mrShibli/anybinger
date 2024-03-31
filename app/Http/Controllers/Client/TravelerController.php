<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Traveler;
use App\Models\TravelerReview;
use App\Models\TravelSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TravelerController extends Controller
{
    public function index(){
        $faqs = Faq::where('show_on', 'traveler')->get();
        $travelerReview = TravelerReview::latest()->get();
        $travelerSetting = TravelSetting::first();

        $data['travelerSetting'] = $travelerSetting;
        $data['faqs'] = $faqs;
        $data['travelerReview'] = $travelerReview;
        return view('client.traveler', $data);
    }
    public function showForm()
    {
        $status = Traveler::where('user_id', Auth::user()->id)->first();
        if (!is_null($status) && $status->status == 'approve') {
            return redirect()->route('traveler.dashboard');
        }
        $travelerSetting = TravelSetting::first();
        return view('client.travels',compact('travelerSetting','status'));
    }
    public function store(Request $request)
    {
        $traveler = Traveler::where('user_id', Auth::user()->id)->first();
        if(!$traveler)
        {
            $validatedData = new Traveler();

            $validator = Validator::make($request->all(),[
                'full_name' => 'required|string|max:255',
                'out_cunt_num' => 'required|string|max:255',
                'bd_number' => 'required|string|max:255',
                'barth' => 'required|date',
                'out_address' => 'required|string|max:255',
                'bd_address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'required|string|max:10',
                'passport' => 'required|file|mimes:jpeg,jpg,png|max:2048',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            if ($request->hasFile('passport')) {
                $passport = $request->file('passport');
                $fileName = Carbon::now()->format('YmdHis') . '_' . $passport->getClientOriginalName();
                $passportPath = $passport->storeAs('travelers', $fileName, 'public');
                $validatedData->passport = $passportPath;
            }
            $validatedData->full_name = $request->full_name;
            $validatedData->out_cunt_num = $request->out_cunt_num;
            $validatedData->bd_number = $request->bd_number;
            $validatedData->barth = $request->barth;
            $validatedData->out_address = $request->out_address;
            $validatedData->bd_address = $request->bd_address;
            $validatedData->city = $request->city;
            $validatedData->state = $request->state;
            $validatedData->zip_code = $request->zip_code;
            $validatedData->user_id = Auth::user()->id;


            $validatedData->save();
            return response()->json(['success' => true, 'message' => 'Traveler information stored successfully']);
        }else{
            return response()->json(['faild'=> true, 'message'=> 'You already requested!']);
        }


    }

}
