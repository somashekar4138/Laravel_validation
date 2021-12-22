<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;


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
    return view('login');
});
Route::get("/register",function () {
    return view('register');
});
Route::post("/register",[userController::class,'registerValidator']);
Route::get("/login",function () {
    return view('login');
});

Route::post("/login",[userController::class,'loginValidator']);

Route::get("/logout",function(){
    if(session()->has('user')){
        session()->pull('user');
    }
    return redirect('login');
});
Route::group(['middleware'=>['CustomAuth']],function(){
    Route::get("/main",function () {
        return view('login');
    });
    Route::get("/list",[userController::class,'List']);
});



