<?php

use App\Http\Controllers\LogViewer\LogViewerController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/logs/errors', [LogViewerController::class, 'errorLogs'])->name('logs.errors');
Route::get('/logs/requests', [LogViewerController::class, 'requestLogs'])->name('logs.requests');
Route::get('/logs/apis', [LogViewerController::class, 'apiLogs'])->name('logs.apis');
