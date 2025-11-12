<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'favicon',
        'primary_color',
        'secondary_color',
        'loan_period',
        'max_books_per_user',
        'fine_amount_per_day'
    ];
}