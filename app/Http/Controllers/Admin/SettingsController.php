<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\HomeCard;
use App\Models\Setting;
use App\Models\TravelSetting;
use App\Models\YoutubeFeedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    public function index(){
        $siteSetting = Setting::first();
        $youtubeFeedback = YoutubeFeedback::first();
        $travelerSetting = TravelSetting::first();
        $homeCard = HomeCard::first();

        $data['homeCard'] = $homeCard;
        $data['travelerSetting'] = $travelerSetting;
        $data['youtubeFeedback'] = $youtubeFeedback;
        $data['siteSetting'] = $siteSetting;
        return view('dashboard.settings.show', $data);
    }

    public function updateProfile(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'security_question' => 'required',
            'phone' => 'required|min:10' 
        ]);

        $admin = Admin::find($id);

        $password = !empty($request->password) ? Hash::make($request->password) : $admin->password;

        if($validator->passes()){
            
            
            $admin->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'security_question' => $request->security_question,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ]);
        }
    }

    public function updateSiteSettings(Request $request){
        $siteSetting = Setting::first();

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:140',
            'logo' => 'mimes:webp|max:80',
            'meta_keyword' => 'required|max:255',
            'meta_description' => 'required|max:255',
            'delivery_dhaka' => 'required|integer',
            'delivery_outside' => 'required|integer',
            'banner_title' => 'required|max:200',
            'banner_url' => 'url|max:255',
            'banner_btn' => 'max:14',
            'banner_paragraph' => 'max:220',
            'banner_image' => 'mimes:webp|max:200',
            'service_phone' => 'required|min:11',
            'service_email' => 'email',
            'footer_paragraph' => 'required|max:255',
            'facebook_url' => 'url',
            'whatsapp_url' => 'url',
            'youtube_url' => 'url'
        ]);


        if($validator->passes()){

            if($request->file('logo')){
                // delete old logo
                $oldLogo = $siteSetting->logo;
                $sourcePath = public_path('uploads/settings/');
                if(file_exists($sourcePath.$oldLogo)){
                    File::delete($sourcePath.$oldLogo);
                }
                // upload and store in database
                $logoImg = $request->file('logo');
                $ext = $logoImg->getClientOriginalExtension();
                $logoName = time() . 'logo.' . $ext;
                $siteSetting->logo = $logoName;
                
                $logoImg->move($sourcePath, $logoName);
            }

            if($request->file('banner_image')){
                // delete old banner
                $oldBanner = $siteSetting->banner_image;
                $sourcePath = public_path('uploads/settings/');
                if(file_exists($sourcePath.$oldBanner)){
                    File::delete($sourcePath.$oldBanner);
                }
                // upload and store in database
                $bannerImg = $request->file('banner_image');
                $ext = $bannerImg->getClientOriginalExtension();
                $bannerName = time() . 'banner.' . $ext;
                $siteSetting->banner_image = $bannerName;
                
                $bannerImg->move($sourcePath, $bannerName);
            }


            $siteSetting->title = $request->title;
            $siteSetting->meta_keyword = $request->meta_keyword;
            $siteSetting->meta_description = $request->meta_description;
            $siteSetting->delivery_dhaka = $request->delivery_dhaka;
            $siteSetting->delivery_outside = $request->delivery_outside;
            $siteSetting->banner_title = $request->banner_title;
            $siteSetting->banner_paragraph = $request->banner_paragraph;
            $siteSetting->banner_link = $request->banner_url;
            $siteSetting->banner_btn = $request->banner_btn;
            $siteSetting->service_phone = $request->service_phone;
            $siteSetting->service_email = $request->service_email;
            $siteSetting->office_time = $request->office_time;
            $siteSetting->footer_desc = $request->footer_paragraph;
            $siteSetting->facebook_url = $request->facebook_url;
            $siteSetting->whatsapp_url = $request->whatsapp_url;
            $siteSetting->youtube_url = $request->youtube_url;

            $siteSetting->save();

            return response()->json([
                'status' => true,
                'message' => 'Setting changes saved 🎉'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ]);
        }

    }

    public function updateFeedback(Request $request){
        $youtubeFeedback = YoutubeFeedback::first();

        $validator = Validator::make($request->all(), [
            'feedback1' => [
                'active_url',
                'regex:/^https:\/\/www\.youtube\.com\/embed\/[a-zA-Z0-9_-]+(\?si=[a-zA-Z0-9_-]+)?$/'
            ],
            'feedback2' => [
                'active_url',
                'regex:/^https:\/\/www\.youtube\.com\/embed\/[a-zA-Z0-9_-]+(\?si=[a-zA-Z0-9_-]+)?$/'
            ],
            'feedback3' => [
                'active_url',
                'regex:/^https:\/\/www\.youtube\.com\/embed\/[a-zA-Z0-9_-]+(\?si=[a-zA-Z0-9_-]+)?$/'
            ]
        ]);


        

        if($validator->passes()){
            $youtubeFeedback->feedback1 = $request->feedback1 ? $request->feedback1 : '';
            $youtubeFeedback->feedback2 = $request->feedback2 ? $request->feedback2 : '';
            $youtubeFeedback->feedback3 = $request->feedback3 ? $request->feedback3 : '';
            $youtubeFeedback->shopper1 = $request->shopper1 ? $request->shopper1 : '';
            $youtubeFeedback->shopper2 = $request->shopper2 ? $request->shopper2 : '';
            $youtubeFeedback->shopper3 = $request->shopper3 ? $request->shopper3 : '';
            $youtubeFeedback->save();

            return response()->json([
                'status' => true,
                'message' => 'Youtube Feedback updated'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ]);
        }
    }

    public function updateTraveler(Request $request){
        $validator = Validator::make($request->all(), [
            'traveler_heading' => 'max:80',
            'traveler_desc' => 'max:200',
            'youtube_title' => 'max:100',
            'youtube_video' => [
                'active_url',
                'regex:/^https:\/\/www\.youtube\.com\/embed\/[a-zA-Z0-9_-]+(\?si=[a-zA-Z0-9_-]+)?$/'
            ],
            'traveler_banner' => 'mimes:webp,max:112'
        ]);


        if($validator->passes()){

            $travelerSetting = TravelSetting::first();


            if ($request->hasFile('traveler_banner')) {
                $oldBanner = $travelerSetting->traveler_banner;
                $sourcePath = public_path('uploads/settings/');

                if (file_exists($sourcePath . $oldBanner)) {
                    File::delete($sourcePath . $oldBanner);
                }

                $bannerImage = $request->file('traveler_banner');
                $newName = time() . 'banner.' . $bannerImage->getClientOriginalExtension();

                // Resize the image to fit 1336x600
                $resizedImage = Image::make($bannerImage)->fit(900, 600);
                
                // Save the resized image
                $resizedImage->save($sourcePath . $newName);

                $travelerSetting->traveler_banner = $newName;
            }


            
            $travelerSetting->traveler_heading = $request->traveler_heading ? $request->traveler_heading : '';
            $travelerSetting->traveler_desc = $request->traveler_desc ? $request->traveler_desc : '';
            $travelerSetting->youtube_title = $request->youtube_title ? $request->youtube_title : '';
            $travelerSetting->youtube_video = $request->youtube_video ? $request->youtube_video : '';
            $travelerSetting->title = $request->title ? $request->title : '';
            $travelerSetting->meta_keyword = $request->meta_keyword ? $request->meta_keyword : '';
            $travelerSetting->meta_description = $request->meta_description ? $request->meta_description : '';
            $travelerSetting->save();

            return response()->json([
                'status' => true,
                'message' => 'Traveler settings updated 🛠'
            ]);
        }else{

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ]);
        }
    }


    public function updateCards(Request $request){
        $homeCard = HomeCard::first();

        if($request->job == 'disableCard'){
            if($homeCard->status == 'published'){
                $homeCard->status = 'pending';
                $homeCard->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Home cards disabled'
                ]);
            }else{
                $homeCard->status = 'published';
                $homeCard->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Home cards enabled'
                ]);
            }
        }else{
            $validator = Validator::make($request->all(), [
                'desc1' => 'max:90',
                'desc2' => 'max:90',
                'desc3' => 'max:90',
                'desc4' => 'max:90',
                'title1' => 'max:50',
                'title2' => 'max:50',
                'title3' => 'max:50',
                'title4' => 'max:50',
            ]);

            if($validator->passes()){
                $homeCard->title1 = $request->title1 ?? '';
                $homeCard->title2 = $request->title2 ?? '';
                $homeCard->title3 = $request->title3 ?? '';
                $homeCard->title4 = $request->title4 ?? '';
                $homeCard->desc1 = $request->desc1 ?? '';
                $homeCard->desc2 = $request->desc2 ?? '';
                $homeCard->desc3 = $request->desc3 ?? '';
                $homeCard->desc4 = $request->desc4 ?? '';
                $homeCard->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Cards updated successfully'
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->first()
                ]);
            }

        }
    }

    // run migration from dashboard
    public function migrateDatabase(){
        try {
            // Run migrations
            Artisan::call('optimize:clear');
            // Get the output
            $output = Artisan::output();

            session()->flash('success', 'site optimized');
            return redirect()->route('secured.dashboard');
        } catch (\Exception $e) {
            session()->flash('error', 'site optimization failed');
            return redirect()->route('secured.dashboard');
        }
    }
}

