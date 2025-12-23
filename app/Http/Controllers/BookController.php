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
        //dd($request->all());
        $request->validate([
            'designation' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $book = new Book();
        $book->designation = $request->input('designation');
        $book->auteur = $request->input('auteur');
        $book->editeur = $request->input('editeur');
        $book->annee = $request->input('annee');
        $book->prix = $request->input('prix');
        $book->type = $request->input('type');
        $book->description = $request->input('description');

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $image = $request->file('cover');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('covers'), $imageName);
            $book->cover = $imageName;
        } else {

            
            $book->cover = 'default-book.png';
        }

        $book->save();

        return redirect()->route('book.index')->with('success', 'Livre ajouté avec succès.');
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
