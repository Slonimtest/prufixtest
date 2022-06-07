<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UploadFileController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [TaskController::class, 'index'])->name('index');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('home/add', [HomeController::class, 'showAddTaskForm'])->name('task.add')->middleware('role:client');
Route::post('/home', [HomeController::class, 'storeTask'])->name('task.store')->middleware('role:client');
Route::get('/home/{task}/edit', [HomeController::class, 'showEditTaskForm'])->name('task.edit')->middleware('role:manager');
Route::patch('/home/{task}', [HomeController::class, 'updateTask'])->name('task.update')->middleware('role:manager');
