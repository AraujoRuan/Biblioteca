<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'fine_amount',
        'notes'
    ];

    protected $casts = [
        'loan_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function calculateFine()
    {
        if ($this->status === 'active' && $this->due_date->isPast()) {
            $daysOverdue = $this->due_date->diffInDays(now());
            $library = Library::first();
            return $daysOverdue * $library->fine_amount_per_day;
        }
        return 0;
    }
}