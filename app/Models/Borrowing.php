<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_date',
        'return_date',
        'status',
    ];

    /**
     * Relasi:
     * Setiap peminjaman dimiliki oleh 1 User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi:
     * Setiap peminjaman memiliki 1 Buku
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
