<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_users' => User::where('role', 'user')->count(),
            'active_loans' => Loan::where('status', 'active')->count(),
            'overdue_loans' => Loan::where('status', 'overdue')->count(),
        ];

        $recentLoans = Loan::with(['user', 'book'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $popularBooks = Book::select('books.*', DB::raw('COUNT(loans.id) as loan_count'))
            ->leftJoin('loans', 'books.id', '=', 'loans.book_id')
            ->groupBy('books.id')
            ->orderBy('loan_count', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recentLoans', 'popularBooks'));
    }
}