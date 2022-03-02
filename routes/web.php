<?php

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

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\
{
    AnnonceController,
    UserController,
    RegisterController,
    LoginController,
    LogoutController
};


Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::get('logout', [LogoutController::class, 'logout'])->name('logout');

Route::post('register', [RegisterController::class, 'register'])->name('post.register');
Route::post('login', [LoginController::class, 'login'])->name('post.login');

Route::get('profile/{user}', [UserController::class, 'profile'])->whereNumber('user')->name('user.profile');

// La page d'accueil (home page) est la page des annonces->index
Route::resource('annonces', AnnonceController::class);

Route::get('/profile/mesannonces', [AnnonceController::class, 'mesannonces'])->name('mesannonces');
Route::resource('profile', AnnonceController::class);

Route::get('/', [AnnonceController::class, 'index'])->name('index');

