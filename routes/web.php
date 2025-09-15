<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/all', [PageController::class, 'show_all_cars'])->name('all-cars');
Route::get('/contact', [ContactController::class, 'show_contanct_page'])->name('contact');
Route::get('/about', [PageController::class, 'GetAboutPage'])->name('aboutpage');
Route::get("/search-carpage", [PageController::class, 'searchCarPage'])->name("Search_car_page");

// Authentication Routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('/add-comment', [PageController::class, 'addComment'])->name('add-comment')->middleware(['auth']);
Route::post('/comment/like', [PageController::class, 'likeComment'])->name('like-comment')->middleware(['auth']);
Route::post("/reply/to/comment", [PageController::class,"reply"])->name("add-reply")->middleware(['auth']);
Route::post("/like-reply", [PageController::class,"like_reply"])->name("like-reply")->middleware(['auth']);
// Auth Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile Routes
    Route::get("/profile/{user_id}", [PageController::class, 'gotoProfile'])->name("profile-go");
    Route::get("/sort-fav-sort-as", [PageController::class, 'gotoProfile'])->name("sort-fav");

    // Car Management Routes
    Route::post('/delete-car', [PageController::class, 'deleteCar'])->name('delete.car');
    Route::post('/delete-all', [PageController::class, 'deleteAll'])->name('delete.all');
    Route::get('/cars/sorted', [PageController::class, 'sortedCars'])->name('sort-cars');

    // Chart/Purchase Routes
    Route::post('/chart/add', [PageController::class, 'addToChart'])->name('Add-Chart');
    Route::get('/purchase-form/{carId}', [PageController::class, 'showPurchaseForm'])->name('purchase.form');
    Route::post('/purchase', [PageController::class, 'processPurchase'])->name('purchaseform');
    Route::post('/chart/remove', [PageController::class, 'removeFromChart'])->name('chart.remove');
    Route::get('/chart', [PageController::class, 'viewChart'])->name('chart.view');
    Route::post('/chart/clear', [PageController::class, 'clearChart'])->name('chart.clear');

    // Favorites Routes
    Route::post('/favorites/add', [PageController::class, 'addToFavorites'])->name("Add-To-Fav");
    Route::post('/favorites/remove', [PageController::class, 'removeFromFavorites'])->name('remove-from-favorites');

    // Search Routes (protected)
    Route::get('/search', [PageController::class, 'search'])->name('cars.search');

    // Account Management Routes
    Route::post("/change-account-details", [PageController::class, 'changeAccount'])->name("account-change");
    Route::post("/change-password", [PageController::class, 'change_password'])->name("change-password");
    Route::post("/delete-account", [PageController::class, 'deleteaccount'])->name("delete.account");

    // Dashboard Routes
    Route::get("/dashboard", [PageController::class, 'sendDashboard'])->name("dashboard.send");
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Management Routes (from ProfileController)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get("/profile/privacy", [ProfileController::class, 'privacy'])->name("profile.privacy");
    Route::get("/profile/email-preferences", [ProfileController::class, 'emailPreferences'])->name("profile.email-preferences");
});

// Emergency fix route (commented out as it should only be used when needed)
// Route::get('/fix-cars', [PageController::class, 'emergencyFixCarCounts'])->name('fix-em');

require __DIR__.'/auth.php';
