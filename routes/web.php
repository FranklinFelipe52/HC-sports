<?php
use App\Http\Controllers\AdminRegistrationController;
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


Route::get('/', [PrfHomeController::class, 'show'])->name('home');
Route::get('/inscricao/{category_id}/{package_id}', [PrfRegistrationController::class, 'create'])->name('inscricao_register_get');
Route::post('/inscricao/{category_id}/{package_id}', [PrfRegistrationController::class, 'store'])->name('inscricao_register_post');
Route::get('/dashboard', [PrfDashboardController::class, 'show'])->middleware('AuthPrfUser')->name('dashboard_user');
Route::get('/profile', [PrfUserController::class, 'profile'])->middleware('AuthPrfUser')->name('profile_user');
Route::get('/registration/update/{id}', [PrfRegistrationController::class, 'update_get'])->middleware('AuthPrfUser')->name('register_update_get');
Route::post('/registration/update/{id}', [PrfRegistrationController::class, 'update_post'])->middleware('AuthPrfUser')->name('register_update_post');
Route::get('/registration/{id}', [PrfCheckoutController::class, 'checkout'])->middleware('AuthPrfUser')->name('register_details');
Route::post('/registration/{id_registration}/vouchers/store', [PrfVauchersController::class, 'store'])->middleware('AuthPrfUser')->name('vouchers_store');
Route::get('/notification_payment', [PrfCheckoutController::class, 'notification'])->name('notification_payment');
Route::post('/notification_payment_webhook', [PrfCheckoutController::class, 'notification_webhook'])->name('notification_payment_webhook');

Route::get('/login', [PrfLoginController::class, 'create'])->middleware('PrfRedirectUserLogin')->name('login_get');
Route::post('/login', [PrfLoginController::class, 'store'])->name('login_post');
Route::get('/logout', [PrfLoginController::class, 'logout'])->name('logout');
Route::get('/forgot_password', [PrfForgotPasswordController::class, 'create'])->middleware('PrfRedirectUserLogin')->name('forgot_password_get');
Route::post('/forgot_password', [PrfForgotPasswordController::class, 'store'])->name('forgot_password_post');
Route::view('/forgot_password_send', 'PRF.Auth.forgot_password_send')->middleware('PrfRedirectUserLogin')->name('forgot_password_send');
Route::get('/password_reset/{token}', [PrfPasswordResetController::class, 'create'])->middleware('PrfRedirectUserLogin')->name('password_reset_get');
Route::post('/password_reset', [PrfPasswordResetController::class, 'store'])->name('password_reset_post');

Route::namespace('Admin')->group(function () {
    Route::redirect('/admin', '/admin/dashboard');
    Route::get('/admin/gen_password/{password}', [AdminController::class, 'gen_password']);

    Route::view('/admin/login', 'PRF.Admin.Auth.login')->name('login_admin_get');
    Route::post('/admin/login', [AdminController::class, 'login'])->name('login_admin_post');
    Route::get('/admin/logout', [AdminController::class, 'logout'])->name('logout_admin');

    Route::get('/admin/profile', [AdminController::class, 'profile'])->middleware('PrfAuthAdmins')->name('profile_admin');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->middleware('PrfAuthAdmins')->name('dashboard_admin');

    Route::get('/admin/users', [AdminUsersController::class, 'index'])->middleware('PrfAuthAdmins')->name('users_admin');
    Route::get('/admin/users/{id}', [AdminUsersController::class, 'single'])->middleware('PrfAuthAdmins')->name('user_admin');
    Route::get('/admin/users/{id}/update', [AdminUsersController::class, 'update_form'])->middleware('PrfAuthAdmins')->name('user_update_admin_get');
    Route::post('/admin/users/{id}/update', [AdminUsersController::class, 'update'])->middleware('PrfAuthAdmins')->name('user_update_admin_post');
    Route::get('/admin/registrations/{id}/update', [AdminRegistrationController::class, 'update_get'])->middleware('PrfAuthAdmins')->name('register_update_admin_get');
    Route::post('/admin/registrations/{id}/update', [AdminRegistrationController::class, 'update_post'])->middleware('PrfAuthAdmins')->name('register_update_admin_post');
    Route::post('/admin/registrations/{registration_id}/confirm', [PrfRegistrationController::class, 'confirm'])->middleware('PrfAuthAdmins')->name('register_confirm_admin_post');
    Route::post('/admin/registrations/{registration_id}/estornar', [PrfRegistrationController::class, 'estorno'])->middleware('PrfAuthAdmins')->name('register_estorno_admin_post');
    Route::post('/admin/registrations/{registration_id}/cancelar', [PrfRegistrationController::class, 'cancelamento'])->middleware('PrfAuthAdmins')->name('register_cancelar_admin_post');

    Route::get('/admin/discounts', [PrfVauchersController::class, 'index'])->middleware('PrfAuthAdmins')->name('discounts_admin_get');
    Route::view('/admin/discounts/new', 'PRF.Admin.discounts_create')->middleware('PrfAuthAdmins')->name('discounts_new_admin_get');
    Route::post('/admin/discounts/{voucher_id}/delete', [PrfVauchersController::class, 'delete'])->middleware('PrfAuthAdmins')->name('discounts_delete_admin_get');

    Route::get('/admin/reports', [AdminReportsController::class, 'index'])->middleware('PrfAuthAdmins')->name('reports_admin_get');

    Route::get('/admin/criar_cupom', [PrfVauchersController::class, 'create_cupom'])->middleware('PrfAuthAdmins')->name('criar_cupom_admin_get');
    Route::post('/admin/criar_cupom', [PrfVauchersController::class, 'store_cupom'])->middleware('PrfAuthAdmins')->name('criar_cupom_admin_post');

    Route::get('/admin/criar_voucher', [PrfVauchersController::class, 'create_voucher'])->middleware('PrfAuthAdmins')->name('criar_voucher_admin_get');
    Route::post('/admin/criar_voucher', [PrfVauchersController::class, 'store_vouchers'])->middleware('PrfAuthAdmins')->name('criar_voucher_admin_post');

    Route::get('/admin/vouchers_relatorio', [PrfVauchersController::class, 'show_voucher_relatorios'])->middleware('PrfAuthAdmins')->name('vouchers_relatorio_admin_get');
    Route::get('/admin/all_vouchers_get', [PrfVauchersController::class, 'all_vouchers_get'])->middleware('PrfAuthAdmins')->name('all_vouchers_get_admin_get');
    Route::get('/admin/vouchers_with_user', [PrfVauchersController::class, 'vouchers_with_user'])->middleware('PrfAuthAdmins')->name('vouchers_with_user_admin_get');

    Route::get('/admin/all_users_get', [AdminReportsController::class, 'all_users_get'])->middleware('PrfAuthAdmins')->name('all_users_get_admin_get');
    Route::get('/admin/all_servidores_get', [AdminReportsController::class, 'all_servidores_get'])->middleware('PrfAuthAdmins')->name('all_servidores_get_admin_get');
    Route::get('/admin/all_confirm_registrations', [AdminReportsController::class, 'all_confirm_registrations'])->middleware('PrfAuthAdmins')->name('all_confirm_registrations_admin_get');
    Route::get('/admin/all_paid_registrations', [AdminReportsController::class, 'all_paid_registrations'])->middleware('PrfAuthAdmins')->name('all_paid_registrations_admin_get');
    Route::get('/admin/all_pending_registrations_get', [AdminReportsController::class, 'all_pending_registrations_get'])->middleware('PrfAuthAdmins')->name('all_pending_registrations_get_admin_get');

    Route::get('/admin/all_confirmed_registrations', [AdminReportsController::class, 'all_confirmed_registrations'])->middleware('PrfAuthAdmins')->name('all_confirmed_registrations_admin_get');
    Route::get('/admin/all_not_confirmed_registrations', [AdminReportsController::class, 'all_not_confirmed_registrations'])->middleware('PrfAuthAdmins')->name('all_not_confirmed_registrations_admin_get');
});
