<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['user', 'book'])->paginate(20);
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->where('is_active', true)->get();
        $books = Book::where('available_copies', '>', 0)->where('status', 'available')->get();
        return view('loans.create', compact('users', 'books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after:loan_date'
        ]);

        $book = Book::find($validated['book_id']);
        
        if ($book->available_copies < 1) {
            return back()->withErrors(['book_id' => 'Este livro não está disponível para empréstimo.']);
        }

        $loan = Loan::create($validated);
        
        // Atualizar cópias disponíveis
        $book->decrement('available_copies');

        return redirect()->route('loans.index')->with('success', 'Empréstimo registrado com sucesso!');
    }

    public function returnBook(Loan $loan)
    {
        if ($loan->status === 'active') {
            $loan->update([
                'return_date' => now(),
                'status' => 'returned',
                'fine_amount' => $loan->calculateFine()
            ]);

            // Atualizar cópias disponíveis
            $loan->book->increment('available_copies');
        }

        return redirect()->route('loans.index')->with('success', 'Livro devolvido com sucesso!');
    }
}