<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

//Route::get('/', function () {
//    return view('welcome');
//});
//

Route::get('/abah', function () {
    return "hello abah";
});


Route::get('/', function () {
    return redirect('issues');
})->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'issues', 'middleware' => ['auth', 'verified']], function () {
   Route::get('/', [IssueController::class, 'index'])->name('issues.index');
   Route::get('/easy', [IssueController::class, 'easy'])->name('issues.easy');
   Route::get('/no-appointment', [IssueController::class, 'no_appointment'])->name('issues.no-appointment');
   Route::get('/more-than-five-sessions', [IssueController::class, 'more_than_five_sessions'])->name('issues.more-than-five-sessions');
   Route::get('/over-age', [IssueController::class, 'over_age'])->name('issues.over-age');
   Route::get('import', [IssueController::class, 'import'])->name('issues.import');
   Route::get('drop-data', [IssueController::class, 'drop_data'])->name('issues.drop-data');
   Route::post('drop-data', [IssueController::class, 'post_drop_database'])->name('issues.post-drop-data');
   Route::get('report', [IssueController::class, 'report'])->name('issues.report');
   Route::post('report', [IssueController::class, 'post_report'])->name('issues.post-report');
   Route::post('create-pdf', [IssueController::class, 'create_pdf'])->name('issues.create-pdf');
   Route::post('import', [IssueController::class, 'importStore'])->name('issues.importStore');
   Route::get('bulk-reports', [IssueController::class, 'bulk_reports'])->name('issues.bulk-reports');
});

Route::group(['prefix' => 'api', 'middleware' => ['auth', 'verified']], function () {
    Route::post('generate-pdf', [ApiController::class, 'generate_pdf'])->name('pages.generate-pdf');
});

require __DIR__.'/auth.php';
