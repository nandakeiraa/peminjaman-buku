<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;

/*
|--------------------------------------------------------------------------
| API ROUTES
|--------------------------------------------------------------------------
| Prefix otomatis: /api
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| AUTH - PUBLIC
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| AUTH - LOGIN REQUIRED
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */
    Route::get('/me', function (Request $request) {
        return response()->json($request->user());
    });

    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | BOOKS (SEMUA USER BISA LIHAT)
    |--------------------------------------------------------------------------
    */
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{id}', [BookController::class, 'show']);

    /*
    |--------------------------------------------------------------------------
    | BORROWING (USER)
    |--------------------------------------------------------------------------
    */
    Route::get('/my-borrowings', [BorrowingController::class, 'myBorrowings']);
    Route::post('/borrowings/borrow', [BorrowingController::class, 'borrow']);
    Route::post('/borrowings/return/{id}', [BorrowingController::class, 'returnBook']);
});

/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | BOOK MANAGEMENT
    |--------------------------------------------------------------------------
    */
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | BORROWING MANAGEMENT
    |--------------------------------------------------------------------------
    */
    Route::get('/borrowings', [BorrowingController::class, 'index']);
});
