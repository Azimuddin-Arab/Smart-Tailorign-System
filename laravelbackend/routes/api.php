<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\{
    CustomerController,
    MeasurementController,
    OrderController,
    OrderItemController,
    PaymentController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fa'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
});

// Public routes (no token required)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']); // optional

// Protected routes (token required)
Route::middleware('auth:sanctum')->group(function () {

    // Authentication
    Route::post('/logout', [AuthController::class, 'logout']);

    // Student CRUD
    Route::apiResource('/students', StudentController::class);

    //  User Management (accessible to all authenticated users)
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    //  Customer CRUD
    Route::apiResource('customers', CustomerController::class);
    Route::get('/customerEdit/{id}', [CustomerController::class, 'edit']);

    //  Measurement CRUD
    Route::apiResource('measurements', MeasurementController::class);

    //  Orders CRUD
    Route::apiResource('orders', OrderController::class);

    //  Order Items CRUD
    Route::apiResource('order-items', OrderItemController::class);

    //  Payments CRUD
    Route::apiResource('payments', PaymentController::class);
});
