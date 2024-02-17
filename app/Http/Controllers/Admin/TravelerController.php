<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FailedTraveler;
use App\Mail\traveler as MailTraveler;
use App\Models\Traveler;
use App\Models\TravelerProduct;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TravelerController extends Controller
{
    public function index(){
        $traveler = Traveler::where('status', 'pending')->get();
        return view("dashboard.travelerreview.req", compact("traveler"));
    }
    public function updateRole(Request $request)
    {
        $traveler = Traveler::find($request->id); // Use find() instead of where() to directly get the model by ID
        if ($traveler) {
            $user = User::find($traveler->user_id);
            if($traveler->status = $request->role == "cancelled"){

                Mail::to($traveler->user->email)->send(new FailedTraveler($traveler));

                NotificationService::Notify($user->id, 'Your traveler request has been cancelled. You can resubmit your information', 'traveler.req');

                $traveler = Traveler::find($request->id);
                if ($traveler->passport) {
                    Storage::disk('public')->delete($traveler->passport);
                }
                $traveler->delete();
                return response()->json(['success'=> true,'message'=> 'Cencelled & Deleted Treveler!']);
            }


            $traveler->status = $request->role;
            $traveler->save();
            
            $user->user_access = 'traveler';
            $user->save();
            NotificationService::Notify($user->id, 'Your traveler request has been approved,', 'traveler.req');
            Mail::to($traveler->user->email)->send(new MailTraveler($traveler));
            return response()->json(['success' => true, 'message' => 'Traveler status updated successfully']);
        } else {
            return response()->json(['faild' => true, 'message' => 'Traveler not found'], 404);
        }
    }
    public function approved()
    {
        $travelers = Traveler::where('status', 'approve')->get();

        foreach ($travelers as $traveler) {
            $user = User::find($traveler->user_id);

            if (!is_null($user)) {
                $user->user_access = 'traveler';
                $user->save();
            }
        }

        return view('dashboard.travelerreview.approved', compact('travelers'));
    }


    public function destroy(Request $request)
    {

        $traveler = Traveler::find($request->id);

        

        if (!is_null($traveler)) {
            $user = User::find($traveler->user_id);

            if (!is_null($user)) {
                $user->user_access = 'user';
                $user->save();
            }

            if (!is_null($traveler->passport)) {
                Storage::disk('public')->delete($traveler->passport);
            }
            
            Mail::to($traveler->user->email)->send(new FailedTraveler($traveler));
            NotificationService::Notify($user->id, 'Your traveler request has been cancelled. You can resubmit your information', 'traveler.req');
            $traveler->delete();

            return response()->json(['success' => true, 'message' => 'Cancelled & Deleted Traveler!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Traveler not found.']);
        }
    }

    public function product ()
    {
        $product = TravelerProduct::all();
        return view('dashboard.travelerreview.travelerProduct', compact('product'));
    }
    public function filterProduct () {
        $product = TravelerProduct::where('status','confirmed')->get();
        return view('dashboard.travelerreview.travelerConfirmed', compact('product'));
    }

}
