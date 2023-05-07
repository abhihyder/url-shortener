<?php

use App\Http\Controllers\Admin\AdminWithdrawalRequestController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\ShortenUrlController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\WithdrawalMethodController;
use App\Http\Controllers\WithdrawalRequestController;
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

Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/about', [LandingPageController::class, 'about'])->name('about');
Route::get('/how-it-work', [LandingPageController::class, 'howItWork'])->name('how-it-work');
Route::get('/terms-and-condition', [LandingPageController::class, 'termsAndCondition'])->name('terms-and-condition');
Route::get('/faq', [LandingPageController::class, 'faq'])->name('faq');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    Route::post('dashboard-data', [DashboardController::class, 'getData'])->name('user.dashboard-data');
    Route::get('shorten-url', [ShortenUrlController::class, 'index'])->name('shorten-url.index');
    Route::get('shorten-url/{id}', [ShortenUrlController::class, 'show'])->name('shorten-url.show');
    Route::post('shorten-url', [ShortenUrlController::class, 'store'])->name('shorten-url.store');
    Route::post('shorten-url/update', [ShortenUrlController::class, 'update'])->name('shorten-url.update');

   
    Route::get('visitor', [VisitorController::class, 'index'])->name('visitor.index');
    Route::get('shorten-url-visitor/{shorten_url_id}', [VisitorController::class, 'shortenUrlVisitor'])->name('visitor.shorten_url_visitor');


    Route::get('user/account', [ProfileController::class, 'index'])->name('user.account');
    Route::post('user/change-theme', [ProfileController::class, 'changeTheme'])->name('user.theme');
    Route::post('user/change-info', [ProfileController::class, 'changeInfo'])->name('user.change-info');
    Route::post('user/change-password', [ProfileController::class, 'changePass'])->name('user.change-pass');
    Route::get('user/withdrawal-request', [WithdrawalRequestController::class, 'index'])->name('withdrawal-request.index');
    Route::post('user/withdrawal-request', [WithdrawalRequestController::class, 'store'])->name('withdrawal-request.store');
    Route::get('user/withdrawal-method', [WithdrawalMethodController::class, 'index'])->name('withdrawal-method.index');
    Route::get('user/withdrawal-method/create', [WithdrawalMethodController::class, 'create'])->name('withdrawal-method.create');
    Route::get('user/withdrawal-method/{id}/edit', [WithdrawalMethodController::class, 'edit'])->name('withdrawal-method.edit');
    Route::post('user/withdrawal-method', [WithdrawalMethodController::class, 'store'])->name('withdrawal-method.store');
    Route::post('user/withdrawal-method/{id}/update', [WithdrawalMethodController::class, 'update'])->name('withdrawal-method.update');
    Route::get('user/statistics', [StatisticsController::class, 'index'])->name('user.statistics');
    Route::post('user/statistics-data', [StatisticsController::class, 'getStatistics'])->name('user.statistics-data');

    Route::post('common/table-data', [HomeController::class, 'tableData'])->name('common.table-data');

    Route::get('referral', [ReferralController::class, 'index'])->name('referral.index');
    Route::get('referral/earning', [ReferralController::class, 'earning'])->name('referral.earning');

    Route::get('referral/banner', [BannerController::class, 'index'])->name('banner.index');
    Route::post('referral/banner', [BannerController::class, 'store'])->name('banner.store');
});

Route::get('c/{url_code}', [VisitorController::class, 'visit'])->name('visitor.visit');
Route::post('vistor-access-code', [VisitorController::class, 'accessCode'])->name('visitor.access_code');