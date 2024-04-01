<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Client\{
    ProductController as CProductController,
    CartController,
    HomeController,
    TravelerController,
    UserController,
    AccountController,
    CheckoutController,
    TravelerDashController,
    TravelerProduct
};
use App\Mail\ResetPasswordMail;

/*  ============
    client side routes
    ============
*/

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/track-order/{invoice_id?}', [HomeController::class, 'trackOrder'])->name('track.order');

// products, category,subcategory products, search products, single routes
Route::get('/products/{search?}', [CProductController::class, 'index'])->name('products');
Route::get('/redirectSearch', [CProductController::class, 'redirectSearch'])->name('redirectSearch');


Route::get('/product/{slug}', [CProductController::class, 'product'])->name('product');
Route::get('/items/{category}/{subcategory?}', [CProductController::class, 'categoryItems'])->name('items');
Route::post('/submit-review/{id}', [CProductController::class, 'saveReview'])->name('account.saveReview');

// cart and checkout routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/cartCount', [CartController::class, 'cartCount'])->name('cartCount');
Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('addToCart');
Route::post('/remove-from-cart/', [CartController::class, 'removeFromCart'])->name('removeFromCart');
Route::post('/update-cart/', [CartController::class, 'updateCart'])->name('updateCart');
Route::post('/add-to-wishlists', [AccountController::class, 'addToWishlist'])->name('account.addToWishlist');


// static pages
Route::get('/pages/{slug}', [HomeController::class, 'pages'])->name('pages');


// guest routes
Route::group(['middleware' => 'guest'],function () {
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::get('/login/google/redirect', [UserController::class, 'redirectToGoogle'])->name('redirectToGoogle');
    Route::post('/login/verify', [UserController::class, 'verifyLogin'])->name('login.verify');
    Route::get('/reset', [UserController::class, 'reset'])->name('reset');
    Route::post('/passResetMail', [UserController::class, 'sendResetEmail'])->name('sendResetEmail');

    //google auth routes
    Route::get('/login/google/redirect', [UserController::class, 'redirectToGoogle'])->name('redirectToGoogle');
    Route::get('/login/google/callback', [UserController::class, 'googleCallback'])->name('googleCallback');
});

// protected rotues, account routes
Route::group(['prefix' => 'account', 'middleware' => 'auth'], function () {
    Route::get('/profile', [AccountController::class, 'account'])->name('account.index');
    Route::post('/withdraw', [AccountController::class, 'withdraw'])->name('account.withdraw');
    Route::get('/payfrom/wallet/{order_id}/{payment_id}', [AccountController::class, 'payFromWallet'])->name('account.payFromWallet');

    Route::put('/update/profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::put('/update/address', [AccountController::class, 'updateAddress'])->name('account.updateAddress');
    Route::get('/notifications', [AccountController::class, 'Notifications'])->name('account.notifications');
    Route::get('/transactions', [AccountController::class, 'Transactions'])->name('account.transactions');




    // wishlist routes
    Route::get('/wishlists', [AccountController::class, 'wishlists'])->name('account.wishlists');
    Route::post('/remove-wishlists', [AccountController::class, 'removeFromWishlist'])->name('account.removeFromWishlist');

    // product request routes
    Route::get('/product/request', [CProductController::class, 'requestProduct'])->name('requestProduct');
    Route::post('/product/save/request', [CProductController::class, 'saveRequestProduct'])->name('saveRequestProduct');
    Route::get('/requests', [CProductController::class, 'myRequests'])->name('account.requests');
    Route::delete('/requests/delete', [CProductController::class, 'statusProduct'])->name('account.deleteRequest');


    // traveler route
    Route::get('/traveler/request', [TravelerController::class, 'showForm'])->name('traveler.req');
    Route::post('/traveler/request', [TravelerController::class, 'store'])->name('traveler.store');
    Route::get('/traveler/dashboard', [TravelerDashController::class, 'index'])->name('traveler.dashboard')->middleware('traveler.dash');
    Route::get('/traveler/products', [TravelerProduct::class, 'index'])->name('traveler.products')->middleware('traveler.dash');
    Route::post('/traveler/product', [TravelerProduct::class, 'add'])->name('traveler.product')->middleware('traveler.dash');
    Route::post('/traveler/delete', [TravelerProduct::class, 'delete'])->name('traveler.product.delete')->middleware('traveler.dash');
    Route::post('/traveler/status', [TravelerProduct::class, 'statusProduct'])->name('traveler.product.status')->middleware('traveler.dash');

    //travelerreviews.filter

    // checkout
    Route::get('/checkout/{type}', [CheckoutController::class, 'checkout'])->name('order.checkout');
    Route::get('/coupon/apply', [CheckoutController::class, 'coupons'])->name('apply.coupon');

    Route::post('/store-order', [CheckoutController::class, 'storeOrder'])->name('order.storeOrder');
    Route::get('/orders/{id?}', [CheckoutController::class, 'orders'])->name('account.orders');
    Route::get('/invoice/{id}', [CheckoutController::class, 'invoice'])->name('invoice.view');
    //payment routes
    Route::get('/bkash/create-payment/{order_id}/{payment_id}', [App\Http\Controllers\BkashTokenizePaymentController::class,'createPayment'])->name('bkash.create.payment');
    Route::get('/bkash/callback', [App\Http\Controllers\BkashTokenizePaymentController::class,'callBack'])->name('bkash.callBack');

    //search payment
    // Route::get('/bkash/search/{trxID}', [App\Http\Controllers\BkashTokenizePaymentController::class,'searchTnx'])->name('bkash.serach');



    Route::get('/logout', [UserController::class, 'logout'])->name('account.logout');
});


Route::get('/notification', function () {
    return view('client.notification');
});

// traveler routes
Route::get('/traveler/', [TravelerController::class, 'index'])->name('traveler.index');


