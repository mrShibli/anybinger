<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductRequest;
use App\Models\Traveler;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $startDate = Carbon::now()->subMonth();
        $endDate = Carbon::now();

        $totalRevenueLastMonth = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total');
        $ordersLastMonth = Order::whereBetween('created_at', [$startDate, $endDate])->latest()->limit(12)->get();
        $productRequests = ProductRequest::whereBetween('created_at', [$startDate, $endDate])->latest()->limit(12)->get();

        $users = User::all()->count();
        $travelers = User::where('user_access' , 'traveler')->count();
        $traveler = Traveler::where('status', 'pending')->get();

        

        $data['totalRevenueLastMonth'] = $totalRevenueLastMonth;
        $data['ordersLastMonth'] = $ordersLastMonth;
        $data['productRequests'] = $productRequests;
        $data['users'] = $users;
        $data['travelers'] = $travelers;
        $data['traveler'] = $traveler;
        return view('dashboard.dashboard', $data);
    }
}
