<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaderController;
use App\Http\Controllers\GiziController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\LaporanAdminController;
use App\Http\Controllers\RekapSartikaController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

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

Route::middleware(['guest'])->group(function () {

    Route::controller(AuthController::class)->group(function(){
        Route::get('register', 'viewDaftar')->name('viewDaftar');
        Route::post('register', 'prosesDaftar')->name('prosesDaftar');
        Route::get('/', 'viewLogin')->name('viewLogin');
        Route::post('prosesLogin', 'prosesLogin')->name('prosesLogin');
    });

});
Route::get('/Logout', [AuthController::class, 'logout'])->name('logout');


//Error
Route::get('/Error', function () {
    return view('Error');
});

//Lupa Password
Route::get('/Lupa-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->middleware('throttle:6,1')->name('password.email');

Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::middleware(['auth', 'role:admin'])->group(function () {

    //Dashboard admin
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/Belum-Melapor', [HomeController::class, 'belumMelapor'])->name('laporan.belum');
    Route::post('/Kirim-Pesan', [HomeController::class, 'kirimPesanBelumMelapor'])->name('laporan.kirimPesanBelum');

    //Laporan
    Route::get('/Laporan', [LaporanAdminController::class, 'index']);
    Route::get('/Laporan/{id}', [LaporanAdminController::class, 'show']);

    //Rekap gizi
    Route::get('/Laporan-Gizi', [GiziController::class, 'index'])->name('Laporan-Gizi');

    //Rekap Sartika
    Route::get('/Laporan-Sartika', [RekapSartikaController::class, 'index'])->name('rekap.sartika');
    Route::get('/Laporan-Sartika/export-excel', [RekapSartikaController::class, 'exportExcel'])->name('rekapSartika.export');

    //Data Sartika
    Route::get('/Data-Sartika', [PosyanduController::class, 'index'])->name('viewDS');
    Route::post('/Data-Sartika', [PosyanduController::class, 'simpanDS'])->name('simpanDS');
    Route::get('/Data-Sartika/{id}', [PosyanduController::class, 'show']);
    Route::get('/Data-Sartika/{id}/edit', [PosyanduController::class, 'showEdit']);
    Route::put('/Data-Sartika/{id}', [PosyanduController::class, 'update']);
    Route::delete('/Data-Sartika/{id}', [PosyanduController::class, 'hapusPos']);
    Route::put('/Data-Sartika/anak/{anak}', [PosyanduController::class, 'updateAnak'])->name('anak.update');
    Route::delete('/Data-Sartika/anak/{anak}', [PosyanduController::class, 'destroy'])->name('anak.destroy');
    Route::post('/Data-Sartika/import', [PosyanduController::class, 'import'])->name('sartika.import');

    // Tambah Pengguna
    Route::get('/Pengguna', [HomeController::class, 'viewPengguna'])->name('viewPengguna');
    Route::get('/Pengguna', [AuthController::class, 'tabelUser'])->name('tabelUser');
    Route::post('/Pengguna', [AuthController::class, 'penggunaBaru'])->name('penggunaBaru');
    Route::delete('/Pengguna/{id}', [AuthController::class, 'hapusUser'])->name('hapusUser');

    //Pengaturan
    Route::get('/Pengaturan-admin', [PengaturanController::class, 'index'])->name('stunting.import.form');
    Route::get('/admin/stunting/template', [PengaturanController::class, 'templateIMT'])->name('stunting.template');
    Route::get('/admin/sartika/template', [PengaturanController::class, 'templates'])->name('sartika.template');
    Route::post('/admin/stunting/import', [PengaturanController::class, 'import'])->name('stunting.import');
    Route::post('/Pengaturan-admin/password', [PengaturanController::class, 'updatePassword'])->name('admin.settings.password'); // submit ubah password





    Route::get('/markAsRead', function() {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('markAsRead');
});

Route::middleware(['auth', 'role:kader'])->group(function () {
    //Kader
    Route::get('/dashboard1', [KaderController::class, 'index']);
    Route::get('/kader/anak/{anak}/edit', [KaderController::class, 'edit'])->name('kader.anak.edit');
    Route::put('/kader/anak/{anak}', [KaderController::class, 'update'])->name('kader.anak.update');
    Route::delete('/kader/anak/{anak}', [KaderController::class, 'destroy'])->name('kader.anak.destroy');

    //Pesan
    Route::get('/Pesan', [KaderController::class, 'viewPesan'])->name('viewPesan');
    Route::get('/Pesan/{pesan}', [KaderController::class, 'showPesan'])->name('showPesan');
    Route::post('/Pesan/{pesan}/read', [KaderController::class, 'markRead'])->name('markRead');

    //Anak
    Route::get('/Regis-anak', [KaderController::class, 'viewRegis']);
    Route::post('/Regis-anak', [KaderController::class, 'simpanRegis'])->name('simpanRegis');

    //Bumil
    Route::get('/Regis-bumil', [KaderController::class, 'viewRegis1']);
    Route::post('/Regis-bumil', [KaderController::class, 'simpanRegis1'])->name('simpanRegis1');

    //Laporan
    Route::get('/Laporan-anak', [KaderController::class, 'viewLaporan']);
    Route::post('/Laporan-simpan', [KaderController::class, 'simpanLaporan'])->name('simpan.Laporan');
    Route::post('/laporan-anak/import', [KaderController::class, 'import'])->name('laporan-anak.import');

    //Riwayat Laporan
    route::get('/Riwayat-laporan', [KaderController::class, 'riwayatLaporan'])->name('riwayat.laporan');
    route::get('/Riwayat-laporan/{id}', [KaderController::class, 'detailRiwayat'])->name('detail.riwayat');

    //Pengaturan
    Route::get('/Pengaturan', [KaderController::class, 'pengaturan'])->name('kader.settings'); // halaman form
    Route::post('/Pengaturan/password', [KaderController::class, 'updatePassword'])->name('kader.settings.password'); // submit ubah password

    //template
    Route::get('/Pengaturan/laporan/template', [KaderController::class, 'templateLaporan'])->name('kader.laporan.template');
});
