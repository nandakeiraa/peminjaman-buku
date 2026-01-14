<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function store(Request $request)
    {
        Loan::create([
            'user_id'=>auth()->id(),
            'book_id'=>$request->book_id,
            'tanggal_pinjam'=>now(),
            'status'=>'dipinjam'
        ]);

        Book::where('id',$request->book_id)->decrement('stok');
        return response()->json(['message'=>'Buku dipinjam']);
    }

    public function returnBook($id)
    {
        $loan = Loan::find($id);
        $loan->update([
            'status'=>'dikembalikan',
            'tanggal_kembali'=>now()
        ]);

        Book::where('id',$loan->book_id)->increment('stok');
        return response()->json(['message'=>'Buku dikembalikan']);
    }
}
