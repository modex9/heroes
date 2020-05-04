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


Route::get('/home', 'HomeController@index')->name('home');

Route::get('register/{referral?}', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::get('r', function() {
    dd(User::all()->first()->logins);
});

//todo: papildomas middleware: ar useris turi herojų?
Route::get('hero', 'HeroController@create')->middleware(['auth', 'admin']);
Route::post('hero', 'HeroController@store')->middleware(['auth', 'admin'])->name('hero.store');