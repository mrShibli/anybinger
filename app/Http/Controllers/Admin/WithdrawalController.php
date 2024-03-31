<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\NotificationService;

class WithdrawalController extends Controller
{
    public function index(){
        $withdrawals = Transaction::with('user')->where('type', 'withdraw')->latest()->paginate(12);
        return view('dashboard.withdrawals.index', compact('withdrawals'));
    }

    public function update(Request $request){
        $withdraw = Transaction::find($request->id);

        if($request->type == 'completed'){
            $withdraw->status = 'completed';
            $withdraw->save();
            NotificationService::Notify($withdraw->user_id, 'Your withdrawal request has been completed', 'account.index');

            return response()->json([
                'status' => true,
                'message' => 'Withdrawal request approved'
            ]);
            
        }else{
            $withdraw->user->balance = $withdraw->user->balance + $withdraw->amount;
            $withdraw->user->save();
            $withdraw->status = 'cancelled';
            $withdraw->save();
            NotificationService::Notify($withdraw->user_id, 'Your withdrawal request has been cancelled', 'account.index');

            return response()->json([
                'status' => true,
                'message' => 'Withdrawal request cancelled'
            ]);
        }
    }
}
