<?php
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CartController
};


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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/products', [CartController::class, 'index'])->name('products.index');

Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');

Route::delete('/cart/remove', [CartController::class, 'remove_from_cart'])->name('cart.remove');

Route::delete('/cart/clear', [CartController::class, 'clear_cart'])->name('cart.clear');

Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
