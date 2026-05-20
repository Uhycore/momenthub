<?php

use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AsUserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ── Guest pages ────────────────────────────────────────────────────────
Route::get('/',        [GuestController::class, 'index'])->name('home');
Route::get('/gallery', [GuestController::class, 'gallery'])->name('gallery');

Route::get('/price',   [GuestController::class, 'price'])
    ->name('price');
// ganti route name jika perlu

// web.php

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard',                      [AsUserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/booking',                   [BookingController::class, 'userIndex'])->name('user.bookings');
    Route::patch('/user/booking/{booking}',       [BookingController::class, 'userUpdate'])->name('user.booking.update');
    Route::patch('/user/booking/{booking}/cancel', [BookingController::class, 'userCancel'])->name('user.booking.cancel');
    Route::post('/booking',                       [BookingController::class, 'store'])->name('booking.store');
    Route::post('/booking/check',                 [BookingController::class, 'checkAvailability'])->name('booking.check');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        });

        Route::prefix('post')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('admin.posts.index');
            Route::get('/create', [PostController::class, 'create'])->name('admin.posts.create');
            Route::post('/', [PostController::class, 'store'])->name('admin.posts.store');
            Route::get('/{post}/edit', [PostController::class, 'edit'])->name('admin.posts.edit');
            Route::put('/{post}', [PostController::class, 'update'])->name('admin.posts.update');
            Route::delete('/{post}', [PostController::class, 'destroy'])->name('admin.posts.destroy');
        });

        Route::prefix('price')->group(function () {
            Route::get('/',                  [PackageController::class, 'index'])->name('admin.price.index');
            Route::post('/',                 [PackageController::class, 'store'])->name('admin.price.store');
            Route::put('/{package}',         [PackageController::class, 'update'])->name('admin.price.update');
            Route::patch('/{package}/toggle', [PackageController::class, 'toggle'])->name('admin.price.toggle');
            Route::delete('/{package}',      [PackageController::class, 'destroy'])->name('admin.price.destroy');
        });

        Route::get('/bookings',          [AdminBookingController::class, 'index'])->name('admin.bookings.index');
        Route::put('/bookings/{booking}', [AdminBookingController::class, 'update'])->name('admin.bookings.update');
        Route::delete('/bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('admin.bookings.destroy');
    });
});

require __DIR__ . '/auth.php';
