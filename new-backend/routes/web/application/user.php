<?php

use App\Http\Controllers\Application\Web\HomeController;
use App\Http\Controllers\Application\Web\Users\AdminsController;
use App\Http\Controllers\Application\Web\Users\CustomersController;
use App\Http\Controllers\Application\Web\Users\SuperAdminsController;
use App\Http\Controllers\Application\Web\Users\WorkersController;
use Illuminate\Support\Facades\Auth;
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

Route::prefix('users')->name('users.')->group(function () {
    Route::resource('customers', CustomersController::class);
    Route::resource('workers', WorkersController::class);
    Route::resource('admins', AdminsController::class);
    Route::resource('super-admins', SuperAdminsController::class);
});
