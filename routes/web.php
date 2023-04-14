<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\ErmController;
use App\Http\Controllers\KasirController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran_pasien');
    Route::post('/simpanpasien_baru', [PendaftaranController::class, 'simpanpasien_baru'])->name('simpanpasien_baru');
    Route::post('/ambildatapasien', [PendaftaranController::class, 'ambilpasien'])->name('ambildatapasien');
    Route::post('/simpanpendaftaran', [PendaftaranController::class, 'simpanpendaftaran'])->name('simpanpendaftaran');
    Route::get('/antrianpasien', [PendaftaranController::class, 'antrianpasien'])->name('antrianpasien');
    Route::post('/ambilantrian', [PendaftaranController::class, 'ambilantrian'])->name('ambilantrian');
    Route::post('/updateantrian', [PendaftaranController::class, 'updateantrian'])->name('updateantrian');
    Route::post('/batalantrian', [PendaftaranController::class, 'batalantrian'])->name('batalantrian');
    Route::post('/batalorder', [ErmController::class, 'batalorder'])->name('batalorder');

    Route::get('/indexerm', [ErmController::class, 'indexerm'])->name('indexerm');
    Route::post('/ambildatapasien_erm', [ErmController::class, 'ambildatapasien_erm'])->name('ambildatapasien_erm');
    Route::post('/ambilform_erm', [ErmController::class, 'ambilform_erm'])->name('ambilform_erm');
    Route::post('/simpanresume', [ErmController::class, 'simpanresume'])->name('simpanresume');
    Route::post('/simpanlayanan', [ErmController::class, 'simpanlayanan'])->name('simpanlayanan');
    Route::post('/tindakanhariini', [ErmController::class, 'tindakanhariini'])->name('tindakanhariini');
    Route::post('/resume_hari_ini', [ErmController::class, 'resume_hari_ini'])->name('resume_hari_ini');
    Route::post('/prosesbayar', [ErmController::class, 'prosesbayar'])->name('prosesbayar');

    Route::get('/pembayaran', [KasirController::class, 'indexkasir'])->name('pembayaran');
    Route::post('/ambildatapasien_bayar', [KasirController::class, 'ambildatapasien_bayar'])->name('ambildatapasien_bayar');
    Route::post('/ambildetail_kasir', [KasirController::class, 'ambildetail_kasir'])->name('ambildetail_kasir');
    Route::post('/prosesterima', [KasirController::class, 'prosesterima'])->name('prosesterima');
    Route::post('/prosesbatal', [KasirController::class, 'prosesbatal'])->name('prosesbatal');
    Route::post('/simpanpembayaran', [KasirController::class, 'simpanpembayaran'])->name('simpanpembayaran');


});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
