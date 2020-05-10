<?php

use Illuminate\Support\Facades\Route;
use App\User;

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

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('register/{referral?}', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::get('r', function() {
//    dd(Auth::user()->isAdmin());
});

Route::resource('hero', 'Admin\HeroController')->middleware(['auth', 'admin']);
Route::resource('faction', 'Admin\FactionController')->middleware(['auth', 'admin']);
Route::resource('user', 'Admin\UserController')->middleware(['auth', 'admin']);
Route::get('admin', 'Admin\AdminController@index')->name('admin')->middleware(['auth', 'admin']);
Route::get('banned', 'BannedController@bannedMessage')->name('banned');
Route::post('ban/{user?}', 'Admin\BanController@execute')->name('ban.execute')->middleware(['auth', 'admin']);
