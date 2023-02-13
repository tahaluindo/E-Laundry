<?php

use App\Http\Controllers\Application\Web\DashboardController;
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

Route::redirect('/', '/login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::middleware('auth')->prefix('application')->name('application.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
     
    //user route
    require_once(__DIR__ . '/web/application/user.php');
});
