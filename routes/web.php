<?php
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
Route::get('/registration/update/{id}', [PrfRegistrationController::class, 'update_get'])->middleware('AuthPrfUser');
Route::post('/registration/update/{id}', [PrfRegistrationController::class, 'update_post'])->middleware('AuthPrfUser');
Route::get('/registration/{id}', [PrfCheckoutController::class, 'checkout'])->middleware('AuthPrfUser');
Route::post('/registration/{id_registration}/vauchers/store', [PrfVauchersController::class, 'store'])->middleware('AuthPrfUser');
Route::get('/notification_payment', [PrfCheckoutController::class, 'notification']);
Route::post('/notification_payment_webhook', [PrfCheckoutController::class, 'notification_webhook']);

Route::get('/login', [PrfLoginController::class, 'create'])->middleware('PrfRedirectUserLogin');
Route::post('/login', [PrfLoginController::class, 'store']);
Route::get('/logout', [PrfLoginController::class, 'logout']);
Route::get('/forgot_password', [PrfForgotPasswordController::class, 'create'])->middleware('PrfRedirectUserLogin');
Route::post('/forgot_password', [PrfForgotPasswordController::class, 'store']);
Route::view( '/forgot_password_send','PRF.Auth.forgot_password_send')->middleware('PrfRedirectUserLogin');
Route::get('/password_reset/{token}', [PrfPasswordResetController::class, 'create'])->middleware('PrfRedirectUserLogin');
Route::post('/password_reset', [PrfPasswordResetController::class, 'store']);

Route::get('/admin/criar_cupom', [PrfVauchersController::class, 'create_cupom']);
Route::post('/admin/criar_cupom', [PrfVauchersController::class, 'store_cupom']);
Route::view('/admin/cupom_criado', 'PRF.Admin.cupom_criado');
Route::get('/admin/criar_voucher', [PrfVauchersController::class, 'create_vaucher']);
Route::post('/admin/criar_voucher', [PrfVauchersController::class, 'store_vauchers']);
Route::view('/admin/voucher_criado', 'PRF.Admin.voucher_criado');
