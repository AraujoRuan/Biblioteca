<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(12);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|unique:books',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_copies' => 'required|integer|min:1',
            'location' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:2048'
        ]);

        $validated['available_copies'] = $validated['total_copies'];

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Livro cadastrado com sucesso!');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'isbn' => 'required|unique:books,isbn,' . $book->id,
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_copies' => 'required|integer|min:1',
            'location' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:2048'
        ]);

        // Calcular cópias disponíveis baseado na diferença
        $copiesDifference = $validated['total_copies'] - $book->total_copies;
        $validated['available_copies'] = max(0, $book->available_copies + $copiesDifference);

        if ($request->hasFile('cover_image')) {
            // Deletar imagem antiga se existir
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso!');
    }

    public function destroy(Book $book)
    {
        // Deletar imagem se existir
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso!');
    }
}