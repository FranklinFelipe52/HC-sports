<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryAdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\ModalidadeAdminController;
use App\Http\Controllers\ModalidadeUserController;
use App\Http\Controllers\NotificationsCheckoutController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegistrationsAdminController;
use App\Http\Controllers\RegistrationsUserController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\testeMail;
use App\Models\Address;
use App\Models\FederativeUnit;
use App\Models\User;
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

Route::get('/', [HomeController::class, 'show'])->middleware('cartSet');
Route::get('/cart', [CartController::class, 'show'])->middleware('cartSet');
Route::post('/cart/{id}', [CartController::class, 'store']);
Route::get('/cart/delete/{key}', [CartController::class, 'delete']);
Route::get('/registration', [RegistrationsUserController::class, 'store']);
Route::post('/notifications', [NotificationsCheckoutController::class, 'store']);
Route::get('/login', [loginController::class, 'create'])->name('GetLogin')->middleware('redirect_user_login');
Route::post('/login', [loginController::class, 'store'])->name('PostLogin');
Route::get('/register', [RegisterController::class, 'create'])->middleware('redirect_user_login');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/forgot_password', [ForgotPasswordController::class, 'create'])->middleware('redirect_user_login');
Route::post('/forgot_password', [ForgotPasswordController::class, 'store']);
Route::get('/password_reset/{token}', [PasswordResetController::class, 'create'])->middleware('redirect_user_login');
Route::post('/password_reset', [PasswordResetController::class, 'store']);
Route::get('/email_verify/{token}', [EmailVerifyController::class, 'EmailVerify'])->middleware('redirect_user_login');
Route::get('/logout', [loginController::class, 'logout']);

Route::get('/user/dashboard', [ModalidadeUserController::class, 'show'])->middleware('AuthUsers');
Route::get('/my-registrations', [RegistrationsUserController::class, 'myRegistrations'])->middleware('AuthUsers');
Route::get('/checkout/{id}', [CheckoutController::class, 'show'])->middleware('AuthUsers');
Route::post('/card/{id}', [CheckoutController::class, 'card'])->middleware('AuthUsers');
Route::get('/pix/{id}', [CheckoutController::class, 'pix'])->middleware('AuthUsers');
Route::get('/Qrcode/pix', [CheckoutController::class, 'pix_view'])->name('pix')->middleware('AuthUsers');

Route::post('/user/registration/{id}', [RegistrationsUserController::class, 'store'])->middleware('AuthUsers');


Route::view('/admin/login', 'Admin/login')->name('GetLoginAdmin')->middleware('redirect_admin_login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/admin/logout', [AdminController::class, 'logout']);
Route::view('/admin/dashboard', 'Admin/dashboard')->middleware('AuthAdmins');

Route::get('/admin/dashboard/modalidade', [ModalidadeAdminController::class, 'show'])->middleware('AuthAdmins');
Route::get('/admin/dashboard/registrations', [RegistrationsAdminController::class, 'show'])->middleware('AuthAdmins');
Route::get('/admin/dashboard/registrations/{id}', [RegistrationsAdminController::class, 'registration'])->middleware('AuthAdmins');
Route::post('/admin/dashboard/registrations/valid', [RegistrationsAdminController::class, 'valid_registration'])->middleware('AuthAdmins');
Route::get('/admin/dashboard/administradores', [AdminController::class, 'show'])->middleware('AuthAdmins');
Route::get('/admin/dashboard/administradores/create', [AdminController::class, 'create'])->middleware('AuthAdmins');
Route::post('/admin/dashboard/administradores/store', [AdminController::class, 'store'])->middleware('AuthAdmins');
Route::post('/admin/dashboard/modalidade', [ModalidadeAdminController::class, 'store']);
Route::post('/admin/dashboard/categoria', [CategoryAdminController::class, 'store']);


