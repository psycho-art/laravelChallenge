<?php

use App\Http\Controllers\Admin\InvitationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Client\TaskController as ClientTaskController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

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

//Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('profile/{id}', [FrontendController::class, 'show'])->name('show');

//Register Routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

// Login routes
Route::get('/login', [AuthController::class, 'loginForm'])->middleware('guest')->name('loginForm');


// Admin Routes
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->as('admin.')->group(function () {

    //Invitations
    Route::get('invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::get('invitations/create', [InvitationController::class, 'create'])->name('invitations.create');
    Route::post('invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::post('invitations/{invitation}/resend', [InvitationController::class, 'resend'])->name('invitations.resend');

    //Tasks
    Route::resource('tasks', TaskController::class);

    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});


//Client Routes
Route::middleware(['auth', 'role:Client'])->prefix('client')->as('client.')->group(function () {
    //Tasks
    Route::resource('tasks', ClientTaskController::class);

    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
