<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'title',
        'author',
        'publisher',
        'publication_year',
        'category',
        'description',
        'cover_image',
        'total_copies',
        'available_copies',
        'status',
        'location'
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function getIsAvailableAttribute()
    {
        return $this->available_copies > 0 && $this->status === 'available';
    }
}