<?php

use App\Http\Controllers\CommandController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\LightingController;
use App\Http\Controllers\LightingTypeController;
use App\Http\Controllers\LightSceneController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PhaseController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SceneController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZoneController;
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
    // Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/test', [UserController::class, 'test'])->name('test');
    Route::get('/do_test', [UserController::class, 'do_test'])->name('do_test');
    Route::get('/do_send_command', [UserController::class, 'do_send_command'])->name('do_send_command');
    Route::get('/handle_connect', [UserController::class, 'handle_connect'])->name('handle_connect');
    Route::get('/handle_input', [UserController::class, 'handle_input'])->name('handle_connect');
    Route::resource('/media', MediaController::class);
    Route::resource('/rooms', RoomController::class);
    Route::post('/rooms/get_room_hardware', [RoomController::class, 'get_room_hardware'])->name('rooms.get_room_hardware');
    Route::post('/rooms/get_room_command', [RoomController::class, 'get_room_command'])->name('rooms.get_room_command');
    Route::post('/rooms/get_room_scenes_and_phases', [RoomController::class, 'get_room_scenes_and_phases'])->name('rooms.get_room_scenes_and_phases');
    Route::resource('/settings', SettingController::class);
    // Route::get('/export_db', [SettingController::class, 'export_db'])->name('settings.export_db');
    Route::resource('/hardwares', HardwareController::class);
    // Route::resource('/lighting_types', LightingTypeController::class);
    Route::resource('/commands', CommandController::class);
    Route::resource('/scenes', SceneController::class);
    Route::get('scenes/{id}/play', [SceneController::class, 'scenes_play'])->name('scenes.play');
    Route::resource('light_scenes', LightSceneController::class);
    // Route::resource('/lightings', LightingController::class);
    Route::resource('/phases', PhaseController::class);
    Route::post('/phases/get_phase_zones', [PhaseController::class, 'get_phase_zones'])->name('phases.get_phase_zones');
    Route::resource('/zones', ZoneController::class);
    Route::post('/upload_media', [MediaController::class, 'upload_media_dropzone'])->name('upload_media');
});
