<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Faq;
use App\Models\StaticPage;
use App\Models\HomeCard;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\SpecialProduct;
use App\Models\YoutubeFeedback;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $siteSetting = '';
        $sliders = Slider::where('status', 'published')->get();
        $feedback = YoutubeFeedback::first();
        $faqs = Faq::where('show_on', 'home')->get();
        $homeCard = HomeCard::first();
        $specialProduct = SpecialProduct::with('product')
                        ->whereHas('product', function ($query) {
                            $query->where('status', 'published');
                        })
                        ->first();

        $latestProducts = Product::with('productImage')->where('status', 'published')->latest()
                            ->whereDoesntHave('specialProduct') // Assuming 'specialProduct' is the relationship method in your Product model
                            ->limit(4)
                            ->get();

        $products = Product::with('productImage')
                    ->where('status', 'published')
                    ->whereDoesntHave('specialProduct')
                    ->inRandomOrder() // Randomize the order
                    ->limit(10)       // Limit to 10 products
                    ->get();
                                    
        $data['latestProduct'] = $latestProducts;
        $data['specialProduct'] = $specialProduct;
        $data['homeCard'] = $homeCard;
        $data['faqs'] = $faqs;
        $data['siteSetting'] = $siteSetting;
        $data['feedback'] = $feedback;
        $data['sliders'] = $sliders;
        $data['products'] = $products;
        return view('client.index', $data);
    }

    public function trackOrder(Request $request){
        $invoice = $request->invoice_id ? $request->invoice_id : '';
        $order = Order::where('invoice_id', $invoice)->first();
        if($invoice){
            $order = Order::where('invoice_id', $invoice)->first();

            return view('client.track', compact('order', 'invoice'));
        }

        return view('client.track', compact('invoice'));
    }


    public function pages($slug){
        $pages = StaticPage::where('slug', $slug)->first();

        if(!$pages){
            return view('errors.404');
        }

        return view('client.pages', compact('pages'));
    }
    
}
