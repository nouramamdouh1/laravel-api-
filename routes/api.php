<?php

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\productController;
use App\Http\Controllers\VerifictionController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::Resource('products',productController::class);
Route::post('register',UserController::class);

Route::prefix('code')->group(function(){
    Route::post('send',[VerifictionController::class,'send']);
    Route::post('verify',[VerifictionController::class,'verify']);
});

Route::prefix('logout')->group(function () {
Route::post('all',[LoginController::class,'logoutall'])->middleware('check-user');
Route::post('current', [LoginController::class,'logoutcurrent'])->middleware('check-user');
Route::post('other',[LoginController::class,'logoutother'])->middleware('check-user');
});

Route::post('login', [LoginController::class,'login']);
Route::resource('brands', BrandController::class);

Route::get('hhh/{product}', [BrandController::class, 'getBrandProducts']);
Route::get('getbrand/{brand}', [ProductController::class, 'getBrand']);
Route::get('getposts', [PostController::class, 'index']);
Route::get('getpost/{post}', [PostController::class, 'show']);


