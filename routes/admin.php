<?php

use App\Http\Controllers\Admin\{
    CategoryController,
    DashboardController,
    AuthController,
    BrandController,
    CouponController,
    FaqController,
    OrderController,
    ProductController,
    ReviewController,
    SettingsController,
    SliderController,
    StaticPageController,
    SubCategoryController,
    TravelerController,
    TravelerReviewController,
    UserController,
};
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Admin\WithdrawalController;
use App\Http\Controllers\Client\TravelerProduct;
use App\Http\Controllers\TempImageController;
use Illuminate\Support\Facades\Route;

use Karim007\LaravelBkashTokenize\Facade\BkashPaymentTokenize;
use Karim007\LaravelBkashTokenize\Facade\BkashRefundTokenize;
use Illuminate\Http\Request;

// Admin dashboard routes

Route::get('secured/question', [AuthController::class, 'showQuestion'])->name('secured.question');
Route::post('secured/verify-question', [AuthController::class, 'verifyQuestion'])->name('secured.verifyQuestion');

Route::group(['prefix' => 'secured', 'middleware' => ['question.verify', 'admin.guest']], function () {
    Route::get('login', [AuthController::class, 'index'])->name('secured.login');
    Route::post('verify-login', [AuthController::class, 'verifyLogin'])->name('secured.verifyLogin');
});





Route::group(['prefix' => 'secured/dashboard', 'middleware' => 'admin.auth'], function () {
    // profile routes
    Route::get('', [DashboardController::class, 'index'])->name('secured.dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('secured.logout');
       Route::post('bkash/refund', function(Request $request) {
        
        $paymentID=$request->paymeent_id;
        $trxID=$request->trungsetion_id;
        $amount=$request->amount;
        $reason='Test';
        $sku='Test';
        //response
        return BkashRefundTokenize::refund($paymentID,$trxID,$amount,$reason,$sku);
    })->name('refundViewPost');


    // temp images routes
    Route::post('products/upload-tempImage', [TempImageController::class, 'storeProductImage'])->name('products.tempImage');
    Route::post('products/delete-Image', [TempImageController::class, 'deleteProductImage'])->name('products.deleteProductImage');

    // category routes
    Route::resource('categories', CategoryController::class);

    // sub category routes
    Route::resource('subcategories', SubCategoryController::class);

    // brands routes
    Route::resource('brands', BrandController::class);

    // products routes
    Route::resource('products', ProductController::class);
    Route::get('productsub/subcategories', [ProductController::class, 'subcategories'])->name('products.subcategory');
    Route::get('product/requests', [ProductController::class, 'requests'])->name('products.requests');
    Route::get('product/requests/{id}', [ProductController::class, 'requestsView'])->name('products.requestsView');
    Route::post('product/accept/request/{id}', [ProductController::class, 'acceptRequest'])->name('products.acceptRequest');
    Route::delete('product/delete/request/{id}', [ProductController::class, 'deleteRequest'])->name('products.deleteRequest');
    Route::get('product/special/', [ProductController::class, 'specialProduct'])->name('products.specialProduct');
    Route::get('product/make-special/{id}', [ProductController::class, 'makeSpecial'])->name('products.makeSpecial');

    // sliders routes
    Route::resource('sliders', SliderController::class);
    Route::post('sliders/updatee/{id}', [SliderController::class, 'updatee'])->name('sliders.change');


    // static pages routes
    Route::get('staticpages', [StaticPageController::class, 'index'])->name('staticpages.index');
    Route::get('staticpages/{id}/edit', [StaticPageController::class, 'edit'])->name('staticpages.edit');
    Route::put('staticpages/{id}/update', [StaticPageController::class, 'update'])->name('staticpages.update');

    // faqs routes
    Route::resource('faqs', FaqController::class);

    // faqs routes
    Route::resource('travelerreviews', TravelerReviewController::class);

    // coupons routes
    Route::resource('coupons', CouponController::class);


    //users & dealers routes
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users/block/{id}', [UserController::class, 'blockUser'])->name('users.blockUser');
    Route::get('users/dealer-page/{id}', [UserController::class, 'dealerView'])->name('users.dealerView');
    Route::post('users/apply-dealer/{id}', [UserController::class, 'dealerApply'])->name('users.dealerApply');
    Route::get('/dealer/lists', [UserController::class, 'allDealers'])->name('users.allDealers');
    Route::post('dealer/descount', [UserController::class,'dealerDescount'])->name('dealer.descount');


    // orders routes
    Route::get('orders', [OrderController::class, 'orders'])->name('orders.index');
    Route::get('orders/new', [OrderController::class, 'newOrders'])->name('orders.newOrders');
    Route::get('orders/pending/payment', [OrderController::class, 'payOrders'])->name('orders.payOrders');
    Route::get('orders/processing', [OrderController::class, 'proOrders'])->name('orders.proOrders');
    Route::get('orders/cancelled', [OrderController::class, 'canOrders'])->name('orders.canOrders');

    Route::get('orders/update/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::put('orders/approvee/{id}', [OrderController::class, 'approvee'])->name('orders.approvee');
    Route::put('orders/itemUpdate', [OrderController::class, 'itemUpdate'])->name('orders.itemUpdate');
    Route::put('orders/updateStatus/{id}', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Route::put('orders/cancelStatus/{id}', [OrderController::class, 'cancelStatus'])->name('orders.cancelStatus');

    Route::post('orders/createPayment', [OrderController::class, 'createPayment'])->name('orders.createPayment');

    Route::delete('orders/deleteItem', [OrderController::class, 'deleteItem'])->name('orders.deleteItem');
    Route::delete('orders/destroy/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');


    // payments
    Route::get('/payments', [OrderController::class, 'payments'])->name('payments.index');


    // review
    // withdrawals requests
    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::put('/withdraw/update', [WithdrawalController::class, 'update'])->name('withdraw.update');


    // review
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/pendings', [ReviewController::class, 'pendings'])->name('reviews.pendings');
    Route::get('/reviews/approve/{id}', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::get('/reviews/delete/{id}', [ReviewController::class, 'delete'])->name('reviews.delete');



    // settings routes
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings/update/profile/{id}', [SettingsController::class, 'updateProfile'])->name('update.profile');
    Route::post('settings/update/settings', [SettingsController::class, 'updateSiteSettings'])->name('update.siteSettings');
    Route::post('settings/update/feedback', [SettingsController::class, 'updateFeedback'])->name('update.feedback');
    Route::post('settings/update/traveler', [SettingsController::class, 'updateTraveler'])->name('update.traveler');
    Route::post('settings/update/cards', [SettingsController::class, 'updateCards'])->name('update.cards');

    Route::get('settings/migrate', [SettingsController::class, 'migrateDatabase'])->name('settings.migrate');
    Route::get('traveler/new', [TravelerController::class, 'index'])->name('admin.traveler.req');
    Route::post('traveler/role/update', [TravelerController::class, 'updateRole'])->name('traveler.role.update');
    Route::get('traveler/approved', [TravelerController::class, 'approved'])->name('admin.traveler.approved');

    Route::post('traveler/destroy', [TravelerController::class,'destroy'])->name('traveler.role.delete');
    Route::get('traveler/product', [TravelerController::class,'product'])->name('travelerreviews.product.admin');
    Route::get('/traveler/filter', [TravelerController::class, 'filterProduct'])->name('travelerreviews.filter');
    Route::get('/order/invoice/{id}', [OrderController::class, 'invoice'])->name('invoice.download');
});
