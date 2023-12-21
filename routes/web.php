<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TreshedNoteController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('notes', NoteController::class)->middleware('auth');
Route::prefix('/trashed')->name('trashed.')->middleware('auth')->group(function(){
    Route::get('/',[TreshedNoteController::class,'index'])->name('index');
    Route::get('/{note}',[TreshedNoteController::class,'show'])->withTrashed()->name('show');
    Route::put('/{note}',[TreshedNoteController::class,'update'])->withTrashed()->name('update');
    Route::delete('/{note}',[TreshedNoteController::class,'destroy'])->withTrashed()->name('destroy');

});

require __DIR__.'/auth.php';
