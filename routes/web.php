<?php
/* pending points - rating, stripe card payment for checkout */
// https://pusher.com/tutorials/multiple-authentication-guards-laravel/
// https://stripe.com/docs/payments/accept-a-payment?platform=web&ui=elements
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('product');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::post('/add-to-cart', [App\Http\Controllers\CartController::class, 'addToCart'])->name('addToCart');
Route::post('/remove-from-cart', [App\Http\Controllers\CartController::class, 'removeFromCart'])->name('removeFromCart');
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
Route::post('/process-checkout', [App\Http\Controllers\CheckoutController::class, 'processCheckout'])->name('processCheckout');
Route::get('/my-account', [CustomerController::class, 'accountHistory'])->name('accountHistory'); 
Route::get('/customers/login', [CustomerController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/customers/login', [CustomerController::class, 'login'])->name('customerLogin'); 
Route::post('/customers/logout', [CustomerController::class, 'logout'])->name('customerLogout');
Route::get('/order/{id}', [App\Http\Controllers\OrderController::class, 'getOrder'])->name('getOrder');
Route::post('/rating', [App\Http\Controllers\RatingController::class, 'addProductRating'])->name('addProductRating'); 

// Route::get('/my-account', function () {
//     return view('pages.myaccount');
// });

Route::get('/thank-you', function () {
    return view('pages.thankyou');
});

// Auth::routes();
