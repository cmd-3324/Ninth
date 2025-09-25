<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Auth;
use App\View\Components\Comments;
Route::middleware(['auth', 'verified'])->controller(PageController::class)->group(function () {
    Route::get('/profile/{user_id}', 'gotoProfile')->name('profile-go');
    Route::get('/sort-fav-sort-as', 'gotoProfile')->name('sort-fav');
    Route::post('/delete-car', 'deleteCar')->name('delete.car');
    Route::post('/delete-all', 'deleteAll')->name('delete.all');
    Route::get('/purchase-form/{carId}', 'showPurchaseForm')->name('purchase.form');
    Route::post('/purchase', 'processPurchase')->name('purchaseform');
    Route::post('/chart/remove', 'removeFromChart')->name('chart.remove');
    Route::get('/chart', 'viewChart')->name('chart.view');
    Route::post('/chart/clear', 'clearChart')->name('chart.clear');
    Route::post('/favorites/add', 'addToFavorites')->name('Add-To-Fav');
    Route::post('/favorites/remove', 'removeFromFavorites')->name('remove-from-favorites');
    Route::get('/search', 'search')->name('cars.search');
    Route::post('/change-account-details', 'changeAccount')->name('account-change');
    Route::post('/change-password', 'change_password')->name('change-password');
    Route::post('/delete-account', 'deleteaccount')->name('delete.account');
    Route::get('/dashboard', 'sendDashboard')->name('dashboard.send');
});

Route::controller(PageController::class)->group(function () {
    Route::get('/all', 'show_all_cars')->name('all-cars');
   Route::post('/chart/add', 'addToChart')->middleware('auth')->name('Add-Chart');
    Route::get('/search-carpage', 'searchCarPage')->name('Search_car_page');
    Route::get('/cars/sorted', 'sortedCars')->name('sort-cars');
    Route::post('/add-comment', 'addComment')->name('add-comment')->middleware('auth');
    Route::post('/comment/like', 'likeComment')->name('like-comment')->middleware('auth');
    Route::post('/reply/to/comment', 'reply')->name('add-reply')->middleware('auth');
    Route::post('/like-reply', 'like_reply')->name('like-reply')->middleware('auth');
});

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [ContactController::class, 'show_contanct_page'])->name('contact');
Route::view('/about', 'aboutus')->name('aboutpage');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware(['auth', 'verified'])->controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'edit')->name('profile.edit');
    Route::patch('/profile', 'update')->name('profile.update');
    Route::delete('/profile', 'destroy')->name('profile.destroy');
    Route::get('/profile/change-password', 'showChangePasswordForm')->name('password.change');
    Route::post('/profile/change-password', 'updatePassword')->name('password.update');
    Route::get('/profile/privacy', 'privacy')->name('profile.privacy');
    Route::get('/profile/email-preferences', 'emailPreferences')->name('profile.email-preferences');
});

Route::fallback(function () {
    if (Auth::check()) {
        $username = Auth::user()->UserName;
        return "This Section is not created Yet Dear $username";
    }
    return "This section is not created Yet Dear User";
});
Route::post('/comments/delete', [Comments::class, 'deleteComment'])->name('delete-comment');

Route::get('/test', [CarController::class,'Testme']);
Route::get('/ff', [CarController::class,'GG']);

require __DIR__.'/auth.php';
