<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'stock',
    ];

    /**
     * Relasi:
     * 1 Buku bisa dipinjam berkali-kali
     */
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
