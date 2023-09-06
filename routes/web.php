<?php
use App\Http\Controllers\PRF\admin\AdminReportsController;
use App\Http\Controllers\PRF\admin\AdminController;
use App\Http\Controllers\PRF\admin\AdminDashboardController;
use App\Http\Controllers\PRF\admin\AdminUsersController;

use App\Http\Controllers\PRF\PrfUserController;
use App\Http\Controllers\PrfCheckoutController;
use App\Http\Controllers\PrfDashboardController;
use App\Http\Controllers\PrfForgotPasswordController;
use App\Http\Controllers\PrfHomeController;
use App\Http\Controllers\PrfLoginController;
use App\Http\Controllers\PrfPasswordResetController;
use App\Http\Controllers\PrfRegistrationController;
use App\Http\Controllers\PrfVauchersController;
use App\Models\PrfVauchers;
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







/* PRF Routes* */


Route::get('/', [PrfHomeController::class, 'show']);
Route::get('/inscricao/{category_id}/{package_id}', [PrfRegistrationController::class, 'create']);
Route::post('/inscricao/{category_id}/{package_id}', [PrfRegistrationController::class, 'store']);
Route::get('/dashboard', [PrfDashboardController::class, 'show'])->middleware('AuthPrfUser');
Route::get('/profile', [PrfUserController::class, 'profile'])->middleware('AuthPrfUser');
Route::get('/registration/update/{id}', [PrfRegistrationController::class, 'update_get'])->middleware('AuthPrfUser');
Route::post('/registration/update/{id}', [PrfRegistrationController::class, 'update_post'])->middleware('AuthPrfUser');
Route::get('/registration/{id}', [PrfCheckoutController::class, 'checkout'])->middleware('AuthPrfUser');
Route::post('/registration/{id_registration}/vouchers/store', [PrfVauchersController::class, 'store'])->middleware('AuthPrfUser');
Route::get('/notification_payment', [PrfCheckoutController::class, 'notification']);
Route::post('/notification_payment_webhook', [PrfCheckoutController::class, 'notification_webhook']);

Route::get('/login', [PrfLoginController::class, 'create'])->middleware('PrfRedirectUserLogin');
Route::post('/login', [PrfLoginController::class, 'store']);
Route::get('/logout', [PrfLoginController::class, 'logout']);
Route::get('/forgot_password', [PrfForgotPasswordController::class, 'create'])->middleware('PrfRedirectUserLogin');
Route::post('/forgot_password', [PrfForgotPasswordController::class, 'store']);
Route::view('/forgot_password_send', 'PRF.Auth.forgot_password_send')->middleware('PrfRedirectUserLogin');
Route::get('/password_reset/{token}', [PrfPasswordResetController::class, 'create'])->middleware('PrfRedirectUserLogin');
Route::post('/password_reset', [PrfPasswordResetController::class, 'store']);

Route::namespace('Admin')->group(function () {
    Route::redirect('/admin', '/admin/dashboard');
    Route::get('/admin/gen_password/{password}', [AdminController::class, 'gen_password']);

    Route::view('/admin/login', 'PRF.Admin.Auth.login');
    Route::post('/admin/login', [AdminController::class, 'login']);
    Route::get('/admin/logout', [AdminController::class, 'logout']);

    Route::get('/admin/profile', [AdminController::class, 'profile'])->middleware('PrfAuthAdmins');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->middleware('PrfAuthAdmins');

    Route::get('/admin/users', [AdminUsersController::class, 'index'])->middleware('PrfAuthAdmins');
    Route::get('/admin/users/{id}', [AdminUsersController::class, 'single'])->middleware('PrfAuthAdmins');
    Route::get('/admin/users/{id}/update', [AdminUsersController::class, 'update_form'])->middleware('PrfAuthAdmins');
    Route::post('/admin/users/{id}/update', [AdminUsersController::class, 'update'])->middleware('PrfAuthAdmins');
    Route::post('/admin/registrations/{registration_id}/confirm', [PrfRegistrationController::class, 'confirm'])->middleware('PrfAuthAdmins');

    Route::get('/admin/discounts', [PrfVauchersController::class, 'index'])->middleware('PrfAuthAdmins');
    Route::view('/admin/discounts/new', 'PRF.Admin.discounts_create')->middleware('PrfAuthAdmins');

    Route::get('/admin/reports', [AdminReportsController::class, 'index'])->middleware('PrfAuthAdmins');

    Route::get('/admin/criar_cupom', [PrfVauchersController::class, 'create_cupom'])->middleware('PrfAuthAdmins');
    Route::post('/admin/criar_cupom', [PrfVauchersController::class, 'store_cupom'])->middleware('PrfAuthAdmins');

    Route::get('/admin/criar_voucher', [PrfVauchersController::class, 'create_voucher'])->middleware('PrfAuthAdmins');
    Route::post('/admin/criar_voucher', [PrfVauchersController::class, 'store_vouchers'])->middleware('PrfAuthAdmins');

    Route::get('/admin/vouchers_relatorio', [PrfVauchersController::class, 'show_voucher_relatorios'])->middleware('PrfAuthAdmins');
    Route::get('/admin/all_vouchers_get', [PrfVauchersController::class, 'all_vouchers_get'])->middleware('PrfAuthAdmins');
    Route::get('/admin/vouchers_with_user', [PrfVauchersController::class, 'vouchers_with_user'])->middleware('PrfAuthAdmins');

    Route::get('/admin/all_users_get', [AdminReportsController::class, 'all_users_get'])->middleware('PrfAuthAdmins');
    Route::get('/admin/all_servidores_get', [AdminReportsController::class, 'all_servidores_get'])->middleware('PrfAuthAdmins');
    Route::get('/admin/all_confirm_registrations', [AdminReportsController::class, 'all_confirm_registrations'])->middleware('PrfAuthAdmins');
    Route::get('/admin/all_paid_registrations', [AdminReportsController::class, 'all_paid_registrations'])->middleware('PrfAuthAdmins');
    Route::get('/admin/all_pending_registrations_get', [AdminReportsController::class, 'all_pending_registrations_get'])->middleware('PrfAuthAdmins');
});

