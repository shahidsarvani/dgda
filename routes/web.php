<?php

use App\Http\Controllers\HardwareController;
use App\Http\Controllers\LightingTypeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
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

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', [UserController::class, 'dashboard'])->name('home');
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::resource('/media', MediaController::class);
    Route::resource('/rooms', RoomController::class);
    Route::resource('/settings', SettingController::class);
    Route::resource('/hardwares', HardwareController::class);
    Route::resource('/lighting_types', LightingTypeController::class);
    Route::post('/upload_media', [MediaController::class, 'upload_media'])->name('upload_media');
});
