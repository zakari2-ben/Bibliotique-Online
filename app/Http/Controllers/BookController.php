<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return view('book.index', compact('books'));
        // $books = \App\Models\Book::all();
        // dd($books->count());
        // $books = \App\Models\Book::all();
        // dd($books);

    
        // dd('KHDAM');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('book.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'designation' => 'required|unique:books',
            'description' => 'required',
            'prix' => 'required'
        ]);

        Book::create($request->all());

        return redirect()->route('book.index')
            ->with('success', 'Livre ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::findOrFail($id);
        return view('book.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        return view('book.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());

        return redirect()->route('book.index')
            ->with('success', 'Livre modifié');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Book::findOrFail($id)->delete();
        return redirect()->route('book.index');
    }
}
