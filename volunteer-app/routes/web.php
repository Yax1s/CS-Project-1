<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrganizationController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// middleware for rerouting url
//Admin Dashboard

Route::middleware(['auth','role:admin'])->group(function() {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->
    name('admin.dashboard');

    Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->
    name('admin.logout');

    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->
    name('admin.profile');

    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->
    name('admin.profile.store');

    Route::get('/admin/change/password', [AdminController::class, 'AdminUpdatePassword'])->
    name('admin.change.password');

    Route::post('/admin/update/password', [AdminController::class, 'AdminChangePassword'])->
    name('update.password');
});

//Vendor Dashboard

Route::middleware(['auth','role:organization'])->group(function() {
    Route::get('/organization/dashboard', [OrganizationController::class, 'OrganizationDashboard'])->
    name('organization.dashboard');

});

Route::get('/admin/login', [AdminController::class, 'AdminLogin']);

