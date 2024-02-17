<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::latest()->paginate(12);
        return view('dashboard.coupons.show', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.coupons.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:coupons',
            'type' => 'required',
            'min_amount' => 'numeric',
            'discount_amount' => 'required|numeric',
            'expire_date' => 'required|date|after:now'
        ]);


        if($validator->passes()){

            Coupon::create([
                'code' => $request->code,
                'type' => $request->type,
                'min_amount' => $request->min_amount,
                'discount_amount' => $request->discount_amount,
                'expire_date' => $request->expire_date,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Coupon created successfully'
            ]);
        }else{

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::find($id);
        if(!$coupon){
            session()->flash('error', 'Coupon not found');
            return redirect()->route('coupons.index');
        }
        return view('dashboard.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $coupon = Coupon::find($id);
        if(!$coupon){
            return response()->json([
                'status' => false,
                'errors' => 'Coupon not found'
            ]);
        }
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'type' => 'required',
            'min_amount' => 'numeric',
            'discount_amount' => 'required|numeric',
            'expire_date' => 'required|date|after:now'
        ]);


        if($validator->passes()){

            $coupon->update([
                'code' => $request->code,
                'type' => $request->type,
                'min_amount' => $request->min_amount,
                'discount_amount' => $request->discount_amount,
                'expire_date' => $request->expire_date,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Coupon updated successfully'
            ]);
        }else{

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::find($id);
        if(!$coupon){
            return response()->json([
                'status' => false,
                'errors' => 'Coupon not found'
            ]);
        }

        $coupon->delete();
        return response()->json([
            'status' => true,
            'message' => 'Coupon deleted successfully'
        ]);
    }
}
