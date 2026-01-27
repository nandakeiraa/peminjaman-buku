<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Semua route di sini otomatis prefix: /api
| Contoh: http://localhost:8000/api/login
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| AUTH (PUBLIC)
|--------------------------------------------------------------------------
| Bisa diakses tanpa login
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
| Wajib pakai token (Sanctum)
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
        return response()->json(['message' => 'Logout berhasil']);
    });

    /*
    |--------------------------------------------------------------------------
    | BOOKS
    |--------------------------------------------------------------------------
    */
    Route::get('/books', [BookController::class, 'index']);     // list buku
    Route::post('/books', [BookController::class, 'store']);    // tambah buku
    Route::get('/books/{id}', [BookController::class, 'show']); // detail buku
    Route::put('/books/{id}', [BookController::class, 'update']);// update buku
    Route::delete('/books/{id}', [BookController::class, 'destroy']); // hapus buku

    /*
    |--------------------------------------------------------------------------
    | BORROWINGS (PEMINJAMAN)
    |--------------------------------------------------------------------------
    */
    Route::get('/borrowings', [BorrowingController::class, 'index']); 
    // semua peminjaman (admin)

    Route::get('/my-borrowings', [BorrowingController::class, 'myBorrowings']); 
    // peminjaman user login

    Route::post('/borrowings/borrow', [BorrowingController::class, 'borrow']); 
    // pinjam buku

    Route::post('/borrowings/return/{id}', [BorrowingController::class, 'returnBook']); 
    // kembalikan buku
});
