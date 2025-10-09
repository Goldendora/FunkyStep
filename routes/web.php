<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// -------------------------------------------------------------
// LOGIN / LOGOUT / REGISTER
// -------------------------------------------------------------

// Formulario de login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Procesar login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Cerrar sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registro de nuevos usuarios
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// -------------------------------------------------------------
// CONTRASEÑA OLVIDADA / RESET
// -------------------------------------------------------------
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// -------------------------------------------------------------
// DASHBOARD PÚBLICO
// -------------------------------------------------------------
// Cualquier usuario (logueado o invitado) puede acceder.
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// -------------------------------------------------------------
// REDIRECCIÓN RAÍZ (Home -> Dashboard)
// -------------------------------------------------------------
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// -------------------------------------------------------------
// RUTAS PROTEGIDAS (solo usuarios autenticados y no baneados)
// -------------------------------------------------------------
Route::middleware(['auth', 'baneo'])->group(function () {

    // ---------------------------------------------------------
    // VERIFICACIÓN 2FA
    // ---------------------------------------------------------
    Route::post('/send-2fa-code', [TwoFactorController::class, 'sendCode'])->name('verify.2fa.send');
    Route::get('/verify-2fa', [TwoFactorController::class, 'showVerifyForm'])->name('verify.2fa');
    Route::post('/verify-2fa', [TwoFactorController::class, 'verify'])->name('verify.2fa.post');

    // ---------------------------------------------------------
    // GESTIÓN DE USUARIOS (SOLO ADMIN)
    // ---------------------------------------------------------
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole');

    // ---------------------------------------------------------
    // SISTEMA DE BANEOS (ADMIN)
    // ---------------------------------------------------------
    Route::post('/users/{id}/ban', [UserController::class, 'ban'])->name('users.ban');
    Route::post('/users/{id}/unban', [UserController::class, 'unban'])->name('users.unban');

    // ---------------------------------------------------------
    // INFORMACIÓN DEL USUARIO
    // ---------------------------------------------------------
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

    
});
