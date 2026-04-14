<?php

use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\PRF\admin\AdminReportsController;
use App\Http\Controllers\PRF\admin\AdminController;
use App\Http\Controllers\PRF\admin\AdminDashboardController;
use App\Http\Controllers\PRF\admin\AdminUsersController;
use App\Http\Controllers\PRF\PrfUserController;
use App\Http\Controllers\PrfDashboardController;
use App\Http\Controllers\PrfForgotPasswordController;
use App\Http\Controllers\PrfHomeController;
use App\Http\Controllers\PrfLoginController;
use App\Http\Controllers\PrfPasswordResetController;
use App\Http\Controllers\PrfRegistrationController;
use Illuminate\Support\Facades\Route;

/* Público */
Route::get('/', [PrfHomeController::class, 'show']);

/* Área do atleta */
Route::get('/dashboard', [PrfDashboardController::class, 'show'])->middleware('AuthPrfUser');
Route::get('/profile', [PrfUserController::class, 'profile'])->middleware('AuthPrfUser');
Route::get('/profile/edit', [PrfUserController::class, 'edit'])->middleware('AuthPrfUser');
Route::post('/profile/edit', [PrfUserController::class, 'update'])->middleware('AuthPrfUser');
Route::get('/registration/update/{id}', [PrfRegistrationController::class, 'update_get'])->middleware('AuthPrfUser');
Route::post('/registration/update/{id}', [PrfRegistrationController::class, 'update_post'])->middleware('AuthPrfUser');

/* Auth */
Route::get('/login', [PrfLoginController::class, 'create'])->middleware('PrfRedirectUserLogin');
Route::post('/login', [PrfLoginController::class, 'store']);
Route::get('/logout', [PrfLoginController::class, 'logout']);
Route::get('/forgot_password', [PrfForgotPasswordController::class, 'create'])->middleware('PrfRedirectUserLogin');
Route::post('/forgot_password', [PrfForgotPasswordController::class, 'store']);
Route::view('/forgot_password_send', 'PRF.Auth.forgot_password_send')->middleware('PrfRedirectUserLogin');
Route::get('/password_reset/{token}', [PrfPasswordResetController::class, 'create'])->middleware('PrfRedirectUserLogin');
Route::post('/password_reset', [PrfPasswordResetController::class, 'store']);

/* Admin */
Route::namespace('Admin')->group(function () {
    Route::redirect('/admin', '/admin/dashboard');
    Route::get('/admin/gen_password/{password}', [AdminController::class, 'gen_password']);

    Route::get('/admin/login', [AdminController::class, 'showLogin']);
    Route::post('/admin/login', [AdminController::class, 'login']);
    Route::get('/admin/logout', [AdminController::class, 'logout']);

    Route::get('/admin/profile', [AdminController::class, 'profile'])->middleware('PrfAuthAdmins');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->middleware('PrfAuthAdmins');

    Route::get('/admin/users', [AdminUsersController::class, 'index'])->middleware('PrfAuthAdmins');
    Route::get('/admin/users/{id}', [AdminUsersController::class, 'single'])->middleware('PrfAuthAdmins');
    Route::get('/admin/users/{id}/update', [AdminUsersController::class, 'update_form'])->middleware('PrfAuthAdmins');
    Route::post('/admin/users/{id}/update', [AdminUsersController::class, 'update'])->middleware('PrfAuthAdmins');

    Route::get('/admin/registrations/{id}/update', [AdminRegistrationController::class, 'update_get'])->middleware('PrfAuthAdmins');
    Route::post('/admin/registrations/{id}/update', [AdminRegistrationController::class, 'update_post'])->middleware('PrfAuthAdmins');
    Route::post('/admin/registrations/{registration_id}/cancelar', [PrfRegistrationController::class, 'cancelamento'])->middleware('PrfAuthAdmins');

    Route::get('/admin/reports', [AdminReportsController::class, 'index'])->middleware('PrfAuthAdmins');
    Route::get('/admin/all_users_get', [AdminReportsController::class, 'all_users_get'])->middleware('PrfAuthAdmins');
});

/* Inscrição — deve ficar por último para não interceptar outras rotas */
Route::get('/{category_id}/{package_id}', [PrfRegistrationController::class, 'create'])->whereNumber(['category_id', 'package_id']);
Route::post('/{category_id}/{package_id}', [PrfRegistrationController::class, 'store'])->whereNumber(['category_id', 'package_id']);
