<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProblemController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get ('/problems/create', [ProblemController::class,'create'])
          ->name('problems.create');
    Route::post('/problems',        [ProblemController::class,'store'])
          ->name('problems.store');
});
Route::get('/problems/{problem:slug}', [ProblemController::class,'show'])
      ->name('problems.show');

require __DIR__.'/auth.php';
