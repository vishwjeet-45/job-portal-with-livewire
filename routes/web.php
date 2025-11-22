<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;


Route::get('/get-states/{country}', function($countryId) {
    return response()->json(
        State::where('country_id', $countryId)->select('id','name')->orderBy('name')->get()
    );
});

Route::get('/get-cities/{state}', function($stateId) {
    return response()->json(
        City::where('state_id', $stateId)->select('id','name')->orderBy('name')->get()
    );
});

Route::get('/', function () {
    return view('frontend.index');
})->name('index')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
