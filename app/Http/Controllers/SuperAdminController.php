<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function settings()
    {
        $library = Library::first();
        return view('super-admin.settings', compact('library'));
    }

    public function updateSettings(Request $request)
    {
        $library = Library::first();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'primary_color' => 'required|string|max:7',
            'secondary_color' => 'required|string|max:7',
            'loan_period' => 'required|integer|min:1',
            'max_books_per_user' => 'required|integer|min:1',
            'fine_amount_per_day' => 'required|numeric|min:0'
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('library', 'public');
        }

        if ($request->hasFile('favicon')) {
            $validated['favicon'] = $request->file('favicon')->store('library', 'public');
        }

        $library->update($validated);

        return redirect()->route('super-admin.settings')->with('success', 'Configurações atualizadas com sucesso!');
    }
}