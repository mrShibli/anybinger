<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dealer;
use App\Models\DealerDescutn;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request){
        $users = User::latest(); 

        $search = $request->search;

        if ($search) {
            $users->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $users = $users->paginate(12);
        return view('dashboard.users.show', compact('users'));
    }

    public function blockUser($id){
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'status' => false,
                'errors' => 'User not found'
            ]);
        }

        if($user->status == 'suspended'){
            $user->status = 'normal';
            $message = 'User Unblocked';
        }else{
            $message = 'User blocked';
            $user->status = 'suspended';
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function dealerView($id){
        $usere = User::find($id);

        if(!$usere){
            return redirect()->route('users.index');
        }

        $user = Dealer::where('user_id', $id)->first();
        if(!$user){

        }
        return view('dashboard.users.edit', compact('user', 'usere'));
    }

    public function dealerApply(Request $request, $id){
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'status' => false,
                'errors' => 'User not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'shop_name' => 'required|max:50',
            'shop_address' => 'required|max:150',
            'contact' => 'required|max:100',
        ]);


        if($validator->passes()){

            $dealer = Dealer::where('user_id', $user->id)->first();

            if($dealer){
                $user->user_access = 'dealer';
                $user->save();
                $dealer->update([
                    'shop_name' => $request->shop_name,
                    'shop_address' => $request->shop_address,
                    'contact' => $request->contact
                ]);
            }else{
                $user->user_access = 'dealer';
                $user->save();
                dd($user->user_access);
                Dealer::create([
                    'user_id' => $id,
                    'shop_name' => $request->shop_name,
                    'shop_address' => $request->shop_address,
                    'contact' => $request->contact
                ]);
            }


            return response()->json([
                'status' => true,
                'message' => 'User account updated to dealer'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ]);
        }
    }

    public function allDealers(){
        $dealer_de = DealerDescutn::first();
        $users = Dealer::with('user')->latest()->paginate(12);
        return view('dashboard.users.dealer', compact('users','dealer_de'));
    }
    public function dealerDescount(Request $request)
    {
        // Assuming you want to update the record with id = 1
        $data = DealerDescutn::findOrFail(1);

        // Validate request data
        $validatedData = $request->validate([
            'descount_dealer' => 'required|integer|max:100',
        ]);

        // Update the record
        $data->update([
            'descount_dealer' => $validatedData['descount_dealer'],
        ]);

        return response()->json(['status' => true, 'message' => 'Data saved successfully']);
    }
}
