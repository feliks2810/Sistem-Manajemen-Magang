<?php

use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EvaluationReportController;
use App\Http\Controllers\Admin\PembimbingController as AdminPembimbingController;
use App\Http\Controllers\Admin\PesertaController as AdminPesertaController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Pembimbing\DashboardController as PembimbingDashboardController;
use App\Http\Controllers\Pembimbing\EvaluationController as PembimbingEvaluationController;
use App\Http\Controllers\Pembimbing\LeaveRequestController as PembimbingLeaveRequestController;
use App\Http\Controllers\Admin\SertifikatPageController as AdminSertifikatPageController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Peserta\AttendanceController as PesertaAttendanceController;
use App\Http\Controllers\Peserta\CertificateController as PesertaCertificateController;
use App\Http\Controllers\Peserta\DashboardController as PesertaDashboardController;
use App\Http\Controllers\Peserta\HistoryController as PesertaHistoryController;
use App\Http\Controllers\Peserta\LeaveController as PesertaLeaveController;
use App\Http\Controllers\Peserta\ProfileController as PesertaProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/lang/{lang}', function ($lang) {
    if (in_array($lang, ['id', 'en'])) {
        session(['locale' => $lang]);
    }
    return back();
})->name('lang.switch');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/lupa-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('/lupa-password', [ForgotPasswordController::class, 'sendEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

    Route::get('peserta', [AdminPesertaController::class, 'index'])->name('peserta.index');
    Route::get('peserta/create', [AdminPesertaController::class, 'create'])->name('peserta.create');
    Route::post('peserta', [AdminPesertaController::class, 'store'])->name('peserta.store');
    Route::get('peserta/{peserta}/edit', [AdminPesertaController::class, 'edit'])->name('peserta.edit');
    Route::put('peserta/{peserta}', [AdminPesertaController::class, 'update'])->name('peserta.update');
    Route::delete('peserta/{peserta}', [AdminPesertaController::class, 'destroy'])->name('peserta.destroy');
    Route::resource('pembimbing', AdminPembimbingController::class)->except(['show']);

    Route::get('/absensi', [AdminAttendanceController::class, 'index'])->name('absensi.index');
    Route::get('/penilaian', [EvaluationReportController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/export', [EvaluationReportController::class, 'exportCsv'])->name('penilaian.export');
    Route::get('/sertifikat', AdminSertifikatPageController::class)->name('sertifikat.page');
    Route::post('/sertifikat/generate', [AdminCertificateController::class, 'generate'])->name('sertifikat.generate');
    Route::get('/sertifikat/download/{certificate}', [AdminCertificateController::class, 'download'])->name('sertifikat.download');

    Route::get('/pengaturan/lokasi', [AdminSettingController::class, 'locationIndex'])->name('setting.location');
    Route::post('/pengaturan/lokasi', [AdminSettingController::class, 'locationUpdate'])->name('setting.location.update');
});

Route::middleware(['auth', 'role:pembimbing'])->prefix('pembimbing')->name('pembimbing.')->group(function (): void {
    Route::get('/dashboard', PembimbingDashboardController::class)->name('dashboard');

    Route::get('/izin-sakit', [PembimbingLeaveRequestController::class, 'index'])->name('leaves.index');
    Route::get('/izin-sakit/{leave}', [PembimbingLeaveRequestController::class, 'show'])->name('leaves.show');
    Route::post('/izin-sakit/{leave}/setujui', [PembimbingLeaveRequestController::class, 'approve'])->name('leaves.approve');
    Route::post('/izin-sakit/{leave}/tolak', [PembimbingLeaveRequestController::class, 'reject'])->name('leaves.reject');

    Route::get('/penilaian', [PembimbingEvaluationController::class, 'index'])->name('evaluation.index');
    Route::get('/penilaian/{peserta}/edit', [PembimbingEvaluationController::class, 'edit'])->name('evaluation.edit');
    Route::put('/penilaian/{peserta}', [PembimbingEvaluationController::class, 'update'])->name('evaluation.update');

    Route::get('/kalender', [\App\Http\Controllers\Pembimbing\AttendanceCalendarController::class, 'index'])->name('calendar.index');
});

Route::middleware(['auth', 'role:peserta'])->prefix('peserta')->name('peserta.')->group(function (): void {
    Route::get('/dashboard', PesertaDashboardController::class)->name('dashboard');

    Route::get('/profil', [PesertaProfileController::class, 'edit'])->name('profile');
    Route::put('/profil', [PesertaProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil/dokumen/{document}', [PesertaProfileController::class, 'destroyDocument'])->name('profile.document.destroy');

    Route::post('/absensi/check-in', [PesertaAttendanceController::class, 'checkIn'])->name('absensi.checkin');
    Route::post('/absensi/check-out', [PesertaAttendanceController::class, 'checkOut'])->name('absensi.checkout');

    Route::get('/izin/baru', [PesertaLeaveController::class, 'create'])->name('leave.create');
    Route::post('/izin', [PesertaLeaveController::class, 'store'])->name('leave.store');

    Route::get('/riwayat-absensi', PesertaHistoryController::class)->name('history');

    Route::get('/sertifikat', [PesertaCertificateController::class, 'show'])->name('certificate');
    Route::get('/sertifikat/download', [PesertaCertificateController::class, 'download'])->name('certificate.download');
    Route::post('/sertifikat/refresh', [PesertaCertificateController::class, 'regenerate'])->name('certificate.refresh');
});
