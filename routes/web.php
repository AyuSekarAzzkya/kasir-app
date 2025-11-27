<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::post('/login/auth', [AuthController::class, 'loginAuth'])->name('login.auth');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard.index');

Route::get('/categories', [App\Http\Controllers\CategoriesController::class, 'index'])->name('admin.categories.index');
Route::post('/categories/store', [App\Http\Controllers\CategoriesController::class, 'store'])->name('admin.categories.store');
Route::put('/admin/categories/{id}', [App\Http\Controllers\CategoriesController::class, 'update'])->name('admin.categories.update');
Route::delete('/admin/categories/{id}', [App\Http\Controllers\CategoriesController::class, 'destroy'])->name('admin.categories.destroy');

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('admin.product.index');
Route::get('/products/data', [App\Http\Controllers\ProductController::class, 'data'])->name('admin.products.data');
Route::get('/products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('admin.products.create');
Route::post('/products/store', [App\Http\Controllers\ProductController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/{id}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('admin.products.destroy');
Route::get('/products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('admin.products.search');

//untuk ambil produk berdasarkan kode
Route::get('/admin/products/by-code/{code}', [App\Http\Controllers\ProductController::class, 'getByCode']);

Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('transaction.index');
Route::post('transactions/store', [App\Http\Controllers\TransactionController::class, 'store'])->name('transactions.store');

Route::get('transactions/history', [App\Http\Controllers\TransactionController::class, 'history'])->name('transactions.history');
Route::get('/transactions/{id}/detail', [App\Http\Controllers\TransactionController::class, 'detail'])->name('transactions.detail');

Route::get('/report', [App\Http\Controllers\ReportController::class, 'index'])->name('admin.report.index');
Route::get('/transaction/{id}/detail', [App\Http\Controllers\ReportController::class, 'detail'])->name('transaction.detail');


Route::post('/stock/in', [App\Http\Controllers\StockController::class, 'stockIn'])->name('stock.in');
Route::post('/stock/out', [App\Http\Controllers\StockController::class, 'stockOut'])->name('stock.out');
Route::get('/stock/history', [StockController::class, 'logHistory'])->name('admin.stock.index');

Route::get('/users', [App\Http\Controllers\AuthController::class, 'index'])->name('admin.user.index');
Route::post('/users/store', [App\Http\Controllers\AuthController::class, 'store'])->name('admin.user.store');
Route::put('/users/{id}', [App\Http\Controllers\AuthController::class, 'update'])->name('admin.user.update');
Route::delete('/users/{id}', [App\Http\Controllers\AuthController::class, 'destroy'])->name('admin.user.destroy');