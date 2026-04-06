<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DrawController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\VerifyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/debug-session', function () {
    return [
        'session_id' => session()->getId(),
        'session_driver' => config('session.driver'),
        'auth_check' => auth()->check(),
        'user_id' => auth()->id(),
        'session_data' => session()->all(),
        'cookies' => request()->cookies->all(),
    ];
});

Route::get('/test-simple', function () {
    return view('draw.test-simple');
})->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::prefix('draw')->name('draw.')->group(function () {
        Route::get('/create', [DrawController::class, 'create'])->name('create');
        Route::get('/{draw}', [DrawController::class, 'show'])->name('show');
        Route::get('/{draw}/pdf', [DrawController::class, 'downloadPdf'])->name('pdf');
        Route::get('/{draw}/excel', [DrawController::class, 'downloadExcel'])->name('excel');
    });
    
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/verify', [VerifyController::class, 'index'])->name('verify');
Route::post('/verify', [VerifyController::class, 'verify'])->name('verify.check');

require __DIR__.'/auth.php';
