<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\CompanyController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\DealController;
use App\Http\Controllers\admin\ActivityController;

use App\Http\Controllers\PageController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\ColorSchemeController;

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

Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
Route::get('color-scheme-switcher/{color_scheme}', [ColorSchemeController::class, 'switch'])->name('color-scheme-switcher');

Route::middleware('loggedin')->group(function() {
    Route::get('login', [AuthController::class, 'loginView'])->name('login.index');
    Route::post('login', [AuthController::class, 'login'])->name('login.check');
    Route::get('register', [AuthController::class, 'registerView'])->name('register.index');
    Route::post('register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function() {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    /*ROLES MODULE*/
    Route::get('roles', [RoleController::class, 'index'])->name('roles');
    Route::get('roles/add', [RoleController::class, 'create'])->name('add');
    Route::post('roles/store', [RoleController::class, 'store'])->name('store');
    Route::get('roles/edit/{id}', [RoleController::class, 'show'])->name('edit');
    Route::post('roles/update/{id}', [RoleController::class, 'update'])->name('update');
    Route::get('roles/delete/{id}', [RoleController::class, 'destroy'])->name('delete');
    /*USER MODULE*/
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('users/add', [UserController::class, 'create'])->name('add');
    Route::post('users/store', [UserController::class, 'store'])->name('store');
    Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('edit');
    Route::post('users/update/{id}', [UserController::class, 'update'])->name('update');
    Route::get('users/delete/{id}', [UserController::class, 'destroy'])->name('delete');
    /*PRODUCT MODULE*/
    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::get('products/add', [ProductController::class, 'create'])->name('add');
    Route::post('products/store', [ProductController::class, 'store'])->name('store');
    Route::get('products/edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::post('products/update/{id}', [ProductController::class, 'update'])->name('update');
    Route::get('products/delete/{id}', [ProductController::class, 'destroy'])->name('delete');   
    /*COMPANY MODULE*/
    Route::get('companies', [CompanyController::class, 'index'])->name('companies');
    Route::get('companies/add', [CompanyController::class, 'create'])->name('add');
    Route::post('companies/store', [CompanyController::class, 'store'])->name('store');
    Route::get('companies/edit/{id}', [CompanyController::class, 'edit'])->name('edit');
    Route::post('companies/update/{id}', [CompanyController::class, 'update'])->name('update');
    Route::get('companies/delete/{id}', [CompanyController::class, 'destroy'])->name('delete');
    
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts');
    Route::get('contacts/add', [ContactController::class, 'create'])->name('add');
    Route::post('contacts/store', [ContactController::class, 'store'])->name('store');
    Route::get('contacts/edit/{id}', [ContactController::class, 'edit'])->name('edit');
    Route::post('contacts/update/{id}', [ContactController::class, 'update'])->name('update');
    Route::get('contacts/delete/{id}', [ContactController::class, 'destroy'])->name('delete');

    Route::get('deals', [DealController::class, 'index'])->name('deals');
    Route::get('deals/add', [DealController::class, 'create'])->name('add');
    Route::post('deals/store', [DealController::class, 'store'])->name('store');
    Route::get('deals/edit/{id}', [DealController::class, 'edit'])->name('edit');
    Route::post('deals/update/{id}', [DealController::class, 'update'])->name('update');
    Route::get('deals/delete/{id}', [DealController::class, 'destroy'])->name('delete');
    Route::get('deals/details/{id}', [DealController::class, 'show'])->name('details');

    Route::get('activities', [ActivityController::class, 'index'])->name('activities');
    Route::get('activities/add', [ActivityController::class, 'create'])->name('add');
    Route::post('activities/store', [ActivityController::class, 'store'])->name('store');
    Route::get('activities/edit/{id}',[ActivityController::class, 'edit'])->name('edit');
    Route::post('activities/update/{id}', [ActivityController::class, 'update'])->name('update');
    Route::get('activities/delete/{id}', [ActivityController::class, 'destroy'])->name('delete');
    Route::get('activities/details/{id}', [ActivityController::class, 'show'])->name('details');


    Route::get('calendar-page', [PageController::class, 'calendar'])->name('calendar');
 
 
  

});
