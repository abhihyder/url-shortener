<?php

use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AdminWithdrawalRequestController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('dashboard-data', [DashboardController::class, 'getData'])->name('admin.dashboard-data');

    Route::get('/setting', [SettingController::class, 'index'])->name('admin.setting.index');
    Route::post('/setting', [SettingController::class, 'store'])->name('admin.setting.store');

    Route::post('statistics-data', [DashboardController::class, 'getStatistics'])->name('admin.statistics-data');
    Route::get('/countries', [CountryController::class, 'index'])->name('admin.country.list');
    Route::post('/countries/store', [CountryController::class, 'store'])->name('admin.country.store');
    Route::post('/countries/rate', [CountryController::class, 'rateChange'])->name('admin.country.change-rate');
    Route::get('/withdrawal-request/index', [AdminWithdrawalRequestController::class, 'index'])->name('admin.withdrawal-request.index');
    Route::get('/withdrawal-request/pending', [AdminWithdrawalRequestController::class, 'pending'])->name('admin.withdrawal-request.pending');
    Route::get('/withdrawal-request/approved', [AdminWithdrawalRequestController::class, 'approved'])->name('admin.withdrawal-request.approved');
    Route::get('/withdrawal-request/complete', [AdminWithdrawalRequestController::class, 'complete'])->name('admin.withdrawal-request.complete');
    Route::get('/withdrawal-request/cancelled', [AdminWithdrawalRequestController::class, 'cancelled'])->name('admin.withdrawal-request.cancelled');
    Route::get('/withdrawal-request/returned', [AdminWithdrawalRequestController::class, 'returned'])->name('admin.withdrawal-request.returned');
    Route::post('/withdrawal-request/update', [AdminWithdrawalRequestController::class, 'update'])->name('admin.withdrawal-request.update');

    Route::get('/payment-method', [PaymentMethodController::class, 'index'])->name('admin.payment-method.index');
    Route::post('/payment-method', [PaymentMethodController::class, 'store'])->name('admin.payment-method.store');
    Route::get('/payment-method/{id}/edit', [PaymentMethodController::class, 'edit'])->name('admin.payment-method.edit');
    Route::post('/payment-method/{id}', [PaymentMethodController::class, 'update'])->name('admin.payment-method.update');
    
    Route::get('/user/list', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('admin.user.store');
    Route::post('/user/get-user', [UserController::class, 'getUser'])->name('admin.user.get-user');
    Route::post('/user/update', [UserController::class, 'update'])->name('admin.user.update');
    Route::post('/user/change-status', [UserController::class, 'changeStatus'])->name('admin.user.change-status');
    Route::post('/user/bulk-change-status', [UserController::class, 'multipleChangeStatus'])->name('admin.user.bulk-change-status');
    Route::post('/user/earning-enable-disable', [UserController::class, 'enableOrDisable'])->name('admin.user.earning-enable-disable');
    Route::post('/user/bulk-earning-enable-disable', [UserController::class, 'multipleEarningEnableOrDisable'])->name('admin.user.bulk-earning-enable-disable');
    Route::post('/user/bulk-delete', [UserController::class, 'multipleDelete'])->name('admin.user.bulk-delete');
});
