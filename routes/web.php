<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controller User
use App\Http\Controllers\MovieController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;

// Controller Admin
use App\Http\Controllers\Admin\AdminStudioController;
use App\Http\Controllers\Admin\AdminSeatController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminPromoController; 
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminMovieController;
use App\Http\Controllers\Admin\AdminScheduleController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| USER AREA (Hanya User Biasa - Admin dilarang masuk)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_user'])->group(function () {

    // --- 1. Alur Utama Pemesanan Tiket ---
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

    // Proses Pembayaran
    Route::get('/payment/{id}', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment/process/{id}', [PaymentController::class, 'process'])->name('payment.process');

    // Riwayat & Tiket
    Route::get('/history', [BookingController::class, 'history'])->name('orders.my_history');
    Route::get('/ticket/{id}', [TicketController::class, 'show'])->name('ticket.show');

    // --- 2. Fitur Akun & Profil ---
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- 3. Fitur Tambahan ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/', [MovieController::class, 'landing'])->name('landing');
    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
    Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');
});

/*
|--------------------------------------------------------------------------
| ADMIN PANEL (Hanya Admin - User Biasa dilarang masuk)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    
    // Dashboard Utama
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Kelola Data Master (Film, Jadwal, Studio, Promo)
    Route::resource('movies', AdminMovieController::class);
    Route::resource('schedules', AdminScheduleController::class);
    Route::resource('studios', AdminStudioController::class);
    Route::resource('promos', AdminPromoController::class);

    // Kelola Pemesanan
    Route::resource('orders', AdminBookingController::class); 
    Route::patch('/orders/{id}/confirm', [AdminBookingController::class, 'confirm'])->name('orders.confirm');

    // Seats Editor (Pengaturan Kursi Studio)
    Route::resource('seats', AdminSeatController::class);
    Route::get('/admin/get-occupied-seats/{schedule_id}', [App\Http\Controllers\Admin\OrderController::class, 'getOccupiedSeats']);
    Route::get('studios/{studio}/seats-editor', [AdminSeatController::class, 'editor'])->name('seats.editor');
    Route::post('studios/{studio}/seats-editor/save', [AdminSeatController::class, 'save'])->name('seats.editor.save');
});