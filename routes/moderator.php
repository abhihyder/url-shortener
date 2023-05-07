<?php

use App\Http\Controllers\Admin\AdminWithdrawalRequestController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'moderator'])->prefix('moderator')->group(function () {
    
    Route::get('/withdrawal-request/index', [AdminWithdrawalRequestController::class, 'index'])->name('moderator.withdrawal-request.index');
    Route::get('/withdrawal-request/pending', [AdminWithdrawalRequestController::class, 'pending'])->name('moderator.withdrawal-request.pending');
    Route::post('/withdrawal-request/update', [AdminWithdrawalRequestController::class, 'update'])->name('moderator.withdrawal-request.update');

});
