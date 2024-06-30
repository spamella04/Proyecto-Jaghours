<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AreaManagerController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(
    function () {
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
        Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

        Route::get('/areas', [AreaController::class, 'index'])->name('areas.index');
        Route::get('/areas/create', [AreaController::class, 'create'])->name('areas.create');
        Route::post('/areas', [AreaController::class, 'store'])->name('areas.store');
        Route::get('/areas/{area}', [AreaController::class, 'show'])->name('areas.show');
        Route::get('/areas/{area}/edit', [AreaController::class, 'edit'])->name('areas.edit');
        Route::put('/areas/{area}', [AreaController::class, 'update'])->name('areas.update');
        Route::delete('/areas/{area}', [AreaController::class, 'destroy'])->name('areas.destroy');

        Route::get('/areamanagers', [AreaManagerController::class, 'index'])->name('areamanagers.index');
        Route::get('/areamanagers/create', [AreaManagerController::class, 'create'])->name('areamanagers.create');
        Route::post('/areamanagers', [AreaManagerController::class, 'store'])->name('areamanagers.store');
        Route::get('/areamanagers/{areamanager}', [AreaManagerController::class, 'show'])->name('areamanagers.show');
        Route::get('/areamanagers/{areamanager}/edit', [AreaManagerController::class, 'edit'])->name('areamanagers.edit');
        Route::put('/areamanagers/{areamanager}', [AreaManagerController::class, 'update'])->name('areamanagers.update');
        Route::delete('/areamanagers/{areamanager}', [AreaManagerController::class, 'destroy'])->name('areamanagers.destroy');
    }
);
