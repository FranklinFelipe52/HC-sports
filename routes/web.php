<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryAdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmRegistrationController;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\ForgotPasswordAdminController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GenerateLinkRegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\ModalidadeAdminController;
use App\Http\Controllers\ModalidadeUserController;
use App\Http\Controllers\NotificationsCheckoutController;
use App\Http\Controllers\PasswordResetAdminController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PersonificationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegistrationsAdminController;
use App\Http\Controllers\RegistrationsUserController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\UserController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\testeMail;
use App\Models\Address;
use App\Models\FederativeUnit;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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



Route::view('/', 'home');
Route::get('/login', [loginController::class, 'create'])->name('GetLogin')->middleware('redirect_user_login');
Route::post('/login', [loginController::class, 'store'])->name('PostLogin');
Route::get('/logout', [loginController::class, 'logout']);
Route::get('/forgot_password', [ForgotPasswordController::class, 'create'])->middleware('redirect_user_login');
Route::post('/forgot_password', [ForgotPasswordController::class, 'store']);
Route::view( '/forgot_password_send','Auth.forgot_password_send')->middleware('redirect_user_login');
Route::get('/password_reset/{token}', [PasswordResetController::class, 'create'])->middleware('redirect_user_login');
Route::post('/password_reset', [PasswordResetController::class, 'store']);


Route::get('/dashboard', [HomeController::class, 'show'])->middleware('AuthUsers');
Route::get('/profile', [UserController::class, 'profile'])->middleware('AuthUsers');
Route::get('/profile/update', [UserController::class, 'create'])->middleware('AuthUsers');
Route::post('/profile/update', [UserController::class, 'update'])->middleware('AuthUsers');
Route::get('/profile/password_reset', [UserController::class, 'password_reset_get'])->middleware('AuthUsers');
Route::post('/profile/password_reset', [UserController::class, 'password_reset_post'])->middleware('AuthUsers');
Route::get('/registration/proof/{id}', [RegistrationsUserController::class, 'show'])->middleware('AuthUsers');


Route::get('/registration/checkout/{id}', [CheckoutController::class, 'checkout'])->middleware('AuthUsers');
Route::get('/notification_payment', [CheckoutController::class, 'notification']);
Route::post('/notification_payment_webhook', [CheckoutController::class, 'notification_webhook']);


Route::get('/admin/profile/update', [AdminController::class, 'create_update'])->middleware('AuthAdmins');
Route::post('/admin/profile/update', [AdminController::class, 'update'])->middleware('AuthAdmins');
Route::get('/admin/profile/password_reset', [AdminController::class, 'password_reset_get'])->middleware('AuthAdmins');
Route::post('/admin/profile/password_reset', [AdminController::class, 'password_reset_post'])->middleware('AuthAdmins');


Route::redirect('/admin', '/admin/login');
Route::view('/admin/login', 'Admin/login')->name('GetLoginAdmin')->middleware('redirect_admin_login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/admin/profile', [AdminController::class, 'profile'])->middleware('AuthAdmins');
Route::get('/admin/logout', [AdminController::class, 'logout']);
Route::get('/admin/users', [UserController::class, 'show'])->middleware('AuthAdmins');
Route::get('/admin/users/{id}', [UserController::class, 'single'])->middleware('AuthAdmins');
Route::get('/admin/users/password_reset/{id}', [ResetPassword::class, 'atleta'])->middleware('AuthAdmins');
Route::get('/admin/users/password_update/{id}', [UserController::class, 'admin_password_update_get'])->middleware('AuthAdmins');
Route::get('/admin/users/link_generate/{id}', [GenerateLinkRegisterController::class, 'create'])->middleware('AuthAdmins');
Route::post('/admin/users/password_update/{id}', [UserController::class, 'admin_password_update_post'])->middleware('AuthAdmins');
Route::get('/admin/users/update/{id}', [UserController::class, 'admin_user_create'])->middleware('AuthAdmins');
Route::post('/admin/users/update/{id}', [UserController::class, 'admin_user_update'])->middleware('AuthAdmins');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'show'])->middleware('AuthAdmins');
Route::get('/admin/modalidade/{id}', [ModalidadeAdminController::class, 'single'])->middleware('AuthAdmins');
Route::get('/admin/modalidades', [ModalidadeAdminController::class, 'show'])->middleware('AuthAdmins');
Route::get('/admin/registration/proof/{id}', [RegistrationsAdminController::class, 'show'])->middleware('AuthAdmins');
Route::get('/admin/registration/create/{id}', [RegistrationsAdminController::class, 'create'])->middleware('AuthAdmins');
Route::get('/admin/registration/delete/{id}', [RegistrationsAdminController::class, 'delete'])->middleware('AuthAdmins');
Route::get('/admin/registration/update/{id}', [RegistrationsAdminController::class, 'edit_get'])->middleware('AuthAdmins');
Route::post('/admin/registration/update/{id}', [RegistrationsAdminController::class, 'edit_post'])->middleware('AuthAdmins');
Route::post('/admin/registration/create/{id}', [RegistrationsAdminController::class, 'store'])->middleware('AuthAdmins');
Route::get('/admin/administradores', [AdminController::class, 'show'])->middleware('AuthAdmins');
Route::get('/admin/administradores/create', [AdminController::class, 'create'])->middleware('AuthAdmins');
Route::get('/admin/administradores/password_reset/{id}', [ResetPassword::class, 'adm'])->middleware('AuthAdmins');
Route::get('/admin/administradores/password_update/{id}', [AdminController::class, 'admin_password_update_get'])->middleware('AuthAdmins');
Route::post('/admin/administradores/password_update/{id}', [AdminController::class, 'admin_password_update_post'])->middleware('AuthAdmins');
Route::get('/admin/administradores/update/{id}', [AdminController::class, 'admin_create'])->middleware('AuthAdmins');
Route::post('/admin/administradores/update/{id}', [AdminController::class, 'admin_update'])->middleware('AuthAdmins');
Route::get('/admin/administradores/{id}', [AdminController::class, 'single'])->middleware('AuthAdmins');
Route::get('/admin/pagamentos', [PaymentsController::class, 'show'])->middleware('AuthAdmins');
Route::get('/admin/pagamentos/confirm/{id}', [PaymentsController::class, 'store'])->middleware('AuthAdmins');
Route::post('/admin/personification/update', [PersonificationController::class, 'Personification']);
Route::get('/admin/personification/off', [PersonificationController::class, 'Personification_off']);
Route::get('/admin/report_registrations', [ReportsController::class, 'RegistrationsReport'])->middleware('AuthAdmins');
Route::get('/admin/logs/{id}', [AdminController::class, 'admin_logs_single'])->middleware('AuthAdmins');
Route::get('/admin/logs', [AdminController::class, 'admin_logs'])->middleware('AuthAdmins');
Route::get('/admin/reports', [ReportsController::class, 'create'])->middleware('AuthAdmins');
Route::post('/admin/reports', [ReportsController::class, 'store'])->middleware('AuthAdmins');
Route::get('/admin/scriptUsers', [ReportsController::class, 'scriptUsers'])->middleware('AuthAdmins');

Route::get('/confirm_registration/{token}', [ConfirmRegistrationController::class, 'create']);
Route::post('/confirm_registration/{token}', [ConfirmRegistrationController::class, 'store']);
Route::post('/admin/administradores/store', [AdminController::class, 'store'])->middleware('AuthAdmins');

Route::get('/admin/forgot_password', [ForgotPasswordAdminController::class, 'create'])->middleware('redirect_admin_login');
Route::post('/admin/forgot_password', [ForgotPasswordAdminController::class, 'store']);
Route::view( '/admin/forgot_password_send','Auth.forgot_password_send_admin')->middleware('redirect_admin_login');

Route::get('/admin/password_reset/{token}', [PasswordResetAdminController::class, 'create'])->middleware('redirect_admin_login');
Route::post('/admin/password_reset', [PasswordResetAdminController::class, 'store']);

