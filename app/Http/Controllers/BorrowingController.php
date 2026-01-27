<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function borrow(Request $request) {
        $book = Book::findOrFail($request->book_id);

        if ($book->stock < 1) {
            return response()->json(['message' => 'Stok habis'], 400);
        }

        $book->decrement('stock');

        return Borrowing::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'borrow_date' => now(),
            'status' => 'dipinjam'
        ]);
    }

    public function returnBook($id) {
        $borrowing = Borrowing::findOrFail($id);

        $borrowing->update([
            'status' => 'dikembalikan',
            'return_date' => now()
        ]);

        $borrowing->book->increment('stock');

        return response()->json(['message' => 'Buku dikembalikan']);
    }
}
