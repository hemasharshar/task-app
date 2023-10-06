<?php

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::group(['middleware' => ['auth', 'role:admin']], function () {

    Route::get('/dashboard-statistics', 'TaskController@getDashboardStatistics');

    Route::get('tasks', [App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');
    Route::get('tasks/getData', [App\Http\Controllers\TaskController::class, 'getData'])->name('tasks.getData');
    Route::get('tasks/create', [App\Http\Controllers\TaskController::class, 'create'])->name('tasks.create');
    Route::post('tasks', [App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');

    Route::get('tasks/getUsers/{role}', [App\Http\Controllers\TaskController::class, 'getUsers'])->name('tasks.getUsers');
});
