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
use App\Http\Controllers\HomeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\ModalidadeAdminController;
use App\Http\Controllers\ModalidadeUserController;
use App\Http\Controllers\NotificationsCheckoutController;
use App\Http\Controllers\PasswordResetAdminController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegistrationsAdminController;
use App\Http\Controllers\RegistrationsUserController;
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



Route::redirect('/', '/login');
Route::get('/login', [loginController::class, 'create'])->name('GetLogin')->middleware('redirect_user_login');
Route::post('/login', [loginController::class, 'store'])->name('PostLogin');
Route::get('/logout', [loginController::class, 'logout']);
Route::get('/forgot_password', [ForgotPasswordController::class, 'create'])->middleware('redirect_user_login');
Route::post('/forgot_password', [ForgotPasswordController::class, 'store']);
Route::view( '/forgot_password_send','Auth.forgot_password_send')->middleware('redirect_user_login');
Route::get('/password_reset/{token}', [PasswordResetController::class, 'create'])->middleware('redirect_user_login');
Route::post('/password_reset', [PasswordResetController::class, 'store']);


Route::get('/dashboard', [HomeController::class, 'show'])->middleware('AuthUsers');
Route::get('/registration/proof/{id}', [RegistrationsUserController::class, 'show'])->middleware('AuthUsers');


Route::get('/checkout/{id}', [CheckoutController::class, 'show'])->middleware('AuthUsers');
Route::post('/card/{id}', [CheckoutController::class, 'card'])->middleware('AuthUsers');
Route::get('/pix/{id}', [CheckoutController::class, 'pix'])->middleware('AuthUsers');
Route::get('/Qrcode/pix', [CheckoutController::class, 'pix_view'])->name('pix')->middleware('AuthUsers');



Route::view('/admin/login', 'Admin/login')->name('GetLoginAdmin')->middleware('redirect_admin_login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/admin/logout', [AdminController::class, 'logout']);
Route::get('/admin/users', [UserController::class, 'show'])->middleware('AuthAdmins');
Route::get('/admin/users/{id}', [UserController::class, 'single'])->middleware('AuthAdmins');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'show'])->middleware('AuthAdmins');
Route::get('/admin/modalidade/{id}', [ModalidadeAdminController::class, 'single'])->middleware('AuthAdmins');
Route::get('/admin/modalidades', [ModalidadeAdminController::class, 'show'])->middleware('AuthAdmins');
Route::get('/admin/registration/proof/{id}', [RegistrationsAdminController::class, 'show'])->middleware('AuthAdmins');
Route::get('/admin/registration/create/{id}', [RegistrationsAdminController::class, 'create'])->middleware('AuthAdmins');
Route::get('/admin/registration/delete/{id}', [RegistrationsAdminController::class, 'delete'])->middleware('AuthAdmins');
Route::post('/admin/registration/create/{id}', [RegistrationsAdminController::class, 'store'])->middleware('AuthAdmins');
Route::get('/admin/administradores', [AdminController::class, 'show'])->middleware('AuthAdmins');
Route::get('/admin/administradores/create', [AdminController::class, 'create'])->middleware('AuthAdmins');
Route::get('/confirm_registration/{token}', [ConfirmRegistrationController::class, 'create']);
Route::post('/confirm_registration/{token}', [ConfirmRegistrationController::class, 'store']);
Route::post('/admin/administradores/store', [AdminController::class, 'store'])->middleware('AuthAdmins');

Route::get('/admin/forgot_password', [ForgotPasswordAdminController::class, 'create'])->middleware('redirect_admin_login');
Route::post('/admin/forgot_password', [ForgotPasswordAdminController::class, 'store']);
Route::view( '/admin/forgot_password_send','Auth.forgot_password_send_admin')->middleware('redirect_admin_login');

Route::get('/admin/password_reset/{token}', [PasswordResetAdminController::class, 'create'])->middleware('redirect_admin_login');
Route::post('/admin/password_reset', [PasswordResetAdminController::class, 'store']);

