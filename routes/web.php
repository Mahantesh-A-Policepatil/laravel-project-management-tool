<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/users', [App\Http\Controllers\UserController::class, 'index']);
Route::resource('/users', App\Http\Controllers\UserController::class);
Route::resource('/projects', App\Http\Controllers\ProjectController::class);
Route::get('/show_data', [App\Http\Controllers\UserController::class, 'index_new'])->name('show_data');
Route::get('usersList', [App\Http\Controllers\UserController::class, 'show_data'])->name('usersList');
Route::post('deleteUser', [App\Http\Controllers\UserController::class, 'delete'])->name('deleteUser');

Route::get('/show_project_data', [App\Http\Controllers\ProjectController::class, 'index'])->name('show_project_data');
Route::get('projectList', [App\Http\Controllers\ProjectController::class, 'showProjecList'])->name('projectList');
Route::post('deleteProject', [App\Http\Controllers\ProjectController::class, 'delete'])->name('deleteProject');
//taskList
Route::get('taskList/{project_id}', [App\Http\Controllers\TaskController::class, 'index'])->name("projectTaskList");
Route::resource('/tasks', App\Http\Controllers\TaskController::class);
Route::get('tasks/create/{project_id}', [App\Http\Controllers\TaskController::class, 'create']);
Route::post('deleteTask/{task_id}', [App\Http\Controllers\TaskController::class, 'delete'])->name('deleteTask');

Route::get('activities/{task_id}', [App\Http\Controllers\ActivityController::class, 'index'])->name("activities");
Route::get('activities/create/{task_id}', [App\Http\Controllers\ActivityController::class, 'create']);
Route::resource('/activities', App\Http\Controllers\ActivityController::class);
Route::get('activityEdit/{activity_id}', [App\Http\Controllers\ActivityController::class, 'edit'])->name('activityEdit');
Route::post('deleteActivity/{activity_id}', [App\Http\Controllers\ActivityController::class, 'delete'])->name('deleteActivity');
