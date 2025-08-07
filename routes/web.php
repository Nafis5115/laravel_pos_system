<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

//User Api
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('send-otp', [UserController::class, 'sendOTPCode']);
Route::post('verify-otp', [UserController::class, 'verifyOTPCode']);
Route::post('reset-password', [UserController::class, 'resetPassword'])
    ->middleware([TokenVerificationMiddleware::class]);
Route::get('logout', [UserController::class, 'logout']);
Route::get('get-user', [UserController::class, 'getUserProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('update-user-profile', [UserController::class, 'updateUserProfile']);

//Page route
Route::get('/', [HomeController::class, 'HomePage']);
Route::get('/userLogin', [UserController::class, 'LoginPage']);
Route::get('/userRegistration', [UserController::class, 'RegistrationPage']);
Route::get('/sendOtp', [UserController::class, 'SendOtpPage']);
Route::get('/verifyOtp', [UserController::class, 'VerifyOTPPage']);
Route::get('/resetPassword', [UserController::class, 'ResetPasswordPage'])
    ->middleware([TokenVerificationMiddleware::class]);
Route::get('/dashboard', [DashboardController::class, 'DashboardPage'])
    ->middleware([TokenVerificationMiddleware::class]);
Route::get('/userProfile', [UserController::class, 'ProfilePage'])
    ->middleware([TokenVerificationMiddleware::class]);
Route::get('/categoryPage', [CategoryController::class, 'CategoryPage'])
    ->middleware([TokenVerificationMiddleware::class]);
Route::get('/customerPage', [CustomerController::class, 'CustomerPage'])
    ->middleware([TokenVerificationMiddleware::class]);
Route::get('/productPage', [ProductController::class, 'ProductPage'])
    ->middleware([TokenVerificationMiddleware::class]);
Route::get('/invoicePage', [InvoiceController::class, 'InvoicePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/salePage', [InvoiceController::class, 'SalePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/reportPage', [ReportController::class, 'ReportPage'])->middleware([TokenVerificationMiddleware::class]);

//Category API
Route::post('create-category', [CategoryController::class, 'createCategory'])->middleware([TokenVerificationMiddleware::class]);
Route::get('list-category', [CategoryController::class, 'categoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('delete-category', [CategoryController::class, 'deleteCategory'])->middleware([TokenVerificationMiddleware::class]);
Route::post('update-category', [CategoryController::class, 'updateCategory'])->middleware([TokenVerificationMiddleware::class]);
Route::post("category-by-id", [CategoryController::class, 'categoryByID'])->middleware([TokenVerificationMiddleware::class]);

// Customer API
Route::post("/create-customer", [CustomerController::class, 'CustomerCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-customer", [CustomerController::class, 'CustomerList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-customer", [CustomerController::class, 'CustomerDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/update-customer", [CustomerController::class, 'CustomerUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/customer-by-id", [CustomerController::class, 'CustomerByID'])->middleware([TokenVerificationMiddleware::class]);

// Product API
Route::post("/create-product", [ProductController::class, 'createProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-product", [ProductController::class, 'deleteProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/product-by-id", [ProductController::class, 'productByID'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-product", [ProductController::class, 'productList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/update-product", [ProductController::class, 'updateProduct'])->middleware([TokenVerificationMiddleware::class]);

// Invoice
Route::post("/invoice-create", [InvoiceController::class, 'invoiceCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/invoice-select", [InvoiceController::class, 'invoiceSelect'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/invoice-details", [InvoiceController::class, 'InvoiceDetails'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/invoice-delete", [InvoiceController::class, 'invoiceDelete'])->middleware([TokenVerificationMiddleware::class]);

// SUMMARY & Report
Route::get("/summary", [DashboardController::class, 'Summary'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/sales-report/{FormDate}/{ToDate}", [ReportController::class, 'SalesReport'])->middleware([TokenVerificationMiddleware::class]);

//
