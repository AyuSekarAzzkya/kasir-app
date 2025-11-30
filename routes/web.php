<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('login');
});

Route::post('/login/auth', [AuthController::class, 'loginAuth'])->name('login.auth');
Route::get('/admin/products/by-code/{code}', [ProductController::class, 'getByCode']);
Route::get('/transactions/print/{id}', [TransactionController::class, 'print'])->name('transaction.print');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['role:admin'])->group(function () {

    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::put('/roles/{role}/update', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}/destroy', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::put('/permissions/{permission}/update', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}/destroy', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

    Route::get('/categories', [CategoriesController::class, 'index'])->name('admin.categories.index');
    Route::post('/categories/store', [CategoriesController::class, 'store'])->name('admin.categories.store');
    Route::put('/admin/categories/{id}', [CategoriesController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{id}', [CategoriesController::class, 'destroy'])->name('admin.categories.destroy');

    Route::get('/products', [ProductController::class, 'index'])->name('admin.product.index');
    Route::get('/products/data', [ProductController::class, 'data'])->name('admin.products.data');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    Route::get('/report', [ReportController::class, 'index'])->name('admin.report.index');
    Route::get('/transaction/{id}/detail', [ReportController::class, 'detail'])->name('transaction.detail');

    Route::post('/stock/in', [StockController::class, 'stockIn'])->name('stock.in');
    Route::post('/stock/out', [StockController::class, 'stockOut'])->name('stock.out');
    Route::get('/stock/history', [StockController::class, 'logHistory'])->name('admin.stock.index');

    Route::get('/users', [CashierController::class, 'index'])->name('admin.user.index');
    Route::post('/users/store', [CashierController::class, 'store'])->name('admin.user.store');
    Route::put('/users/{id}', [CashierController::class, 'update'])->name('admin.user.update');
    Route::delete('/users/{id}', [CashierController::class, 'destroy'])->name('admin.user.destroy');

    Route::get('/admins', [AdminController::class, 'index'])->name('user.admin');
    Route::post('/admins/store', [AdminController::class, 'store'])->name('admin.store');
    Route::put('/admins/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admins/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
});

Route::middleware(['role:cashier'])->group(function () {

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction.index');
    Route::post('transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('transactions/history', [TransactionController::class, 'history'])->name('transactions.history');
    Route::get('/transactions/{id}/detail', [TransactionController::class, 'detail'])->name('transactions.detail');
});
