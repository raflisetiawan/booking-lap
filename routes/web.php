<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DayFieldController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OwnerVenueController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TestController;
use App\Http\Middleware\Authenticate;
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

Route::resource('/venues', \App\Http\Controllers\VenueController::class);
Route::get('/venues/{venue}/show', [\App\Http\Controllers\VenueController::class, 'show'])->name('venues.show');
Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard.index');
Route::get('/',[DashboardController::class,'index']);
Route::post('/login', [LoginController::class,'authenticate'])->name('authenticate');
Route::get('/login', function(){
    return view('auth.login');
})->name('login');
Route::post('/register', [RegisterController::class,'store'])->name('daftar');
Route::get('/register', function(){
    return view('auth.register');
});

Route::get('/logout', [LoginController::class,'logout'])->name('logout');
Route::get('/owner-venue', [OwnerVenueController::class,'index'])->name('Dashboard-owner');
Route::get('/owner-venue/create-field', [FieldController::class,'create'])->name('create-field');
Route::post('/owner-venue/create-field', [FieldController::class,'store'])->name('post-field');
Route::get('/owner-venue/fields', [FieldController::class, 'index' ])->name('index-field');
Route::get('/owner-venue/edit-field/{id}', [FieldController::class, 'edit' ])->name('edit-field');
Route::patch('/owner-venue/edit-field/{id}', [FieldController::class, 'update' ])->name('update-field');
Route::delete('/owner-venue/delete-field/{id}', [FieldController::class, 'destroy' ])->name('delete-field');
Route::get('/owner-venue/show-field/{id}', [FieldController::class, 'show' ])->name('show-field');
Route::get('/search-fields', [FieldController::class, 'search'])->name('search-fields');

Route::get('/owner-venue/fields/day', [DayFieldController::class, 'index' ])->name('index-day');
Route::get('/owner-venue/fields/day/create', [DayFieldController::class, 'create' ])->name('create-day');
Route::post('/owner-venue/fields/day/create', [DayFieldController::class, 'store' ])->name('store-day');

Route::get('/owner-venue/fields/schedule/{id}', [ScheduleController::class, 'index' ])->name('index-schedule');
Route::get('/owner-venue/fields/schedule/create/{id}', [ScheduleController::class, 'create' ])->name('create-schedule');
Route::post('/owner-venue/fields/schedule/create/{id}', [ScheduleController::class, 'store' ])->name('store-schedule');
Route::put('/owner-venue/fields/schedule/{id}/update-booking', [ScheduleController::class, 'updateIsBooking'])->name('schedule.updateIsBooking');
Route::get('/owner-venue/booking', [OwnerVenueController::class, 'allBooking'])->name('bookings.all');

Route::put('/owner-venue/booking/{id}/update-status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');




Route::get('/bookings/{venueId}', [BookingController::class, 'show'])->name('bookings.show');
Route::post('/bookings/{venueId}', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
// Route::get('/admin', [AdminController::class, 'index'])->name('contact.index');
Route::get('/admin/contact', [ContactController::class, 'index'])->name('contacts.index');
Route::get('/admin/venues', [AdminController::class, 'getAllVenues'])->name('admin.venues');
Route::put('/venues/{id}/approve', [AdminController::class, 'updateApprove'])->name('venues.updateApprove');
Route::get('/profil/{id}', [UserController::class, 'show'])->name('profil.index');
Route::get('/profil/edit/{id}', [UserController::class, 'edit'])->name('profil.edit');
Route::put('/profil/update/{id}', [UserController::class, 'update'])->name('profil.update');



Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
Route::get('/about', [AboutController::class, 'index'])->name('about.index');

