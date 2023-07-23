<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Middleware\CheckUserType;

use App\Models\Category;

// Route::get('/dashboard', [DashboardController::class, 'index'])
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::resource('dashboard/categories', CategoriesController::class)
//     ->middleware('auth');

// Route::group([
//     'middleware' => ['auth'],
//     'as' => 'dashboard.',  //->name(start with dashboard.)
//     'prefix' => 'dashboard' //foe get('/start with dashboard/')

// ], function () {

//     Route::get('/', [DashboardController::class, 'index'])
//         ->name('dashboard');

//     Route::resource('/categories', CategoriesController::class);
// });

// CheckUserType::class i'm bulid this middleware in http folder middleware to prevent the user enter in dashboard
// عشان امنع اليوزر يدخل على الداش بورد
//or use الاختصار  in kernel 'auth','auth.type'
//if you want passing parameter to middleware Name:passing para..



//beacuse the admin is table and user anthoertable not need ,CheckUserType::class  middleware
// auth:admin admin is guard to able to enter in dashboard beacause use two guard web (for user) and admin

Route::middleware(['auth:admin'])->as('dashboard.')->prefix('admin/dashboard')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', [DashboardController::class, 'index'])
        ->middleware(['verified'])
        ->name('dashboard');

    Route::get('/categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
    //{category} to sure number ->where('category','\d+') d =>digit
    Route::delete('/categories/{category}/force-delete', [CategoriesController::class, 'forceDelete'])->name('categories.force-delete');


    Route::resource('/categories', CategoriesController::class);
    Route::resource('/products', ProductsController::class);
});
