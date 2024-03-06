<?php

use App\Http\Controllers\FrontendController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Auth::routes(['register'=>false]);

Route::get('user/register',[FrontendController::class,'register'])->name('register.form');
Route::post('user/register',[FrontendController::class,'registerSubmit'])->name('register.submit');

Auth::routes();

Route::get('/',[FrontendController::class,'home'])->name('home');
