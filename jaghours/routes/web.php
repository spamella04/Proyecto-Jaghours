<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AreaManagerController;
use App\Http\Controllers\JobOportunityController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\AdminJobOpportunityController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\HourRecordController;
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

        Route::get('/joboportunity/manager', [JobOportunityController::class, 'index'])->name('joboportunity.index');
        Route::get('/joboportunity/student', [JobOportunityController::class, 'indexStudent'])->name('joboportunity.indexStudent');
        Route::get('/joboportunity/create', [JobOportunityController::class, 'create'])->name('joboportunity.create');
        Route::post('/joboportunity', [JobOportunityController::class, 'store'])->name('joboportunity.store');
        Route::get('/joboportunity/{joboportunity}', [JobOportunityController::class, 'show'])->name('joboportunity.show');
        Route::get('/joboportunity/{joboportunity}/edit', [JobOportunityController::class, 'edit'])->name('joboportunity.edit');
        Route::put('/joboportunity/{joboportunity}', [JobOportunityController::class, 'update'])->name('joboportunity.update');
        Route::delete('/joboportunity/{joboportunity}', [JobOportunityController::class, 'destroy'])->name('joboportunity.destroy');
        Route::get('/joboportunity/{id}/showapplicants', [JobOportunityController::class, 'showApplicants'])->name('joboportunity.showapplicants');


        
        Route::get('/degrees', [DegreeController::class, 'index'])->name('degrees.index');
        Route::get('/degrees/create', [DegreeController::class, 'create'])->name('degrees.create');
        Route::post('/degrees', [DegreeController::class, 'store'])->name('degrees.store');
        Route::get('/degrees/{degree}', [DegreeController::class, 'show'])->name('degrees.show');
        Route::get('/degrees/{degree}/edit', [DegreeController::class, 'edit'])->name('degrees.edit');
        Route::put('/degrees/{degree}', [DegreeController::class, 'update'])->name('degrees.update');
        Route::delete('/degrees/{degree}', [DegreeController::class, 'destroy'])->name('degrees.destroy');

        Route::get('/semesters', [SemesterController::class, 'index'])->name('semesters.index');
        Route::get('/semesters/create', [SemesterController::class, 'create'])->name('semesters.create');
        Route::post('/semesters', [SemesterController::class, 'store'])->name('semesters.store');
        Route::get('/semesters/{semester}', [SemesterController::class, 'show'])->name('semesters.show');
        Route::get('/semesters/{semester}/edit', [SemesterController::class, 'edit'])->name('semesters.edit');
        Route::put('/semesters/{semester}', [SemesterController::class, 'update'])->name('semesters.update');
        Route::delete('/semesters/{semester}', [SemesterController::class, 'destroy'])->name('semesters.destroy');

        //JobOpportunity - Admin
        Route::get('/adminjobopportunities', [AdminJobOpportunityController::class, 'index'])->name('adminjobopportunities.index');
        Route::get('/adminjobopportunities/create', [AdminJobOpportunityController::class, 'create'])->name('adminjobopportunities.create');
        Route::post('/adminjobopportunities', [AdminJobOpportunityController::class, 'store'])->name('adminjobopportunities.store');
        Route::get('/adminjobopportunities/{adminjobopportunity}', [AdminJobOpportunityController::class, 'show'])->name('adminjobopportunities.show');
        Route::get('/adminjobopportunities/{adminjobopportunity}/edit', [AdminJobOpportunityController::class, 'edit'])->name('adminjobopportunities.edit');
        Route::put('/adminjobopportunities/{adminjobopportunity}', [AdminJobOpportunityController::class, 'update'])->name('adminjobopportunities.update');
        Route::delete('/adminjobopportunities/{adminjobopportunity}', [AdminJobOpportunityController::class, 'destroy'])->name('adminjobopportunities.destroy');
        Route::get('/adminjobopportunities/{adminjobopportunity}/publish', [AdminJobOpportunityController::class, 'publish'])->name('adminjobopportunities.publish');
        Route::get('/adminjobopportunities/{adminjobopportunity}/reject', [AdminJobOpportunityController::class, 'reject'])->name('adminjobopportunities.reject');

        //Applications
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
        Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
        Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
        Route::get('/applications/{application}/edit', [ApplicationController::class, 'edit'])->name('applications.edit');
        Route::put('/applications/{application}', [ApplicationController::class, 'update'])->name('applications.update');
        Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
        //Jobs
        Route::get('/job', [JobController::class, 'index'])->name('job.index');
        Route::post('/job', [JobController::class, 'store'])->name('job.store');
        
        //Hour Records
        Route::get('/hourrecord/create/{job_id}', [HourRecordController::class, 'create'])->name('hourrecords.create');
        Route::post('/hourrecord/store', [HourRecordController::class, 'store'])->name('hourrecords.store');

    }
);
