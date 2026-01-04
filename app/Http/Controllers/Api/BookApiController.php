<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;

class BookApiController extends Controller
{
    // GET /api/books
    public function index()
    {
        return BookResource::collection(Book::latest()->get());
    }

    // POST /api/books
    public function store(Request $request)
    {
        $data = $request->validate([
            'designation' => 'required|unique:books',
            'description' => 'required',
            'prix' => 'numeric',
            'auteur' => 'required',
            'annee' => 'required|date',
            'type' => 'nullable',
            'langue' => 'nullable',
            'editeur' => 'nullable',
            'categorie' => 'nullable',
        ]);

        // default cover
        $data['cover'] = $data['cover'] ?? 'no_cover.jpg';

        $book = Book::create($data);

        return new BookResource($book);
    }

    // GET /api/books/{id}
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return new BookResource($book);
    }

    // PUT /api/books/{id}
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $data = $request->validate([
            'designation' => 'required|unique:books,designation,' . $book->id,
            'description' => 'required',
            'prix' => 'numeric',
            'auteur' => 'required',
            'annee' => 'required|date',
            'type' => 'nullable',
            'langue' => 'nullable',
            'editeur' => 'nullable',
            'categorie' => 'nullable',
        ]);

        $book->update($data);

        return new BookResource($book);
    }

    // DELETE /api/books/{id}
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json([
            'message' => 'Livre supprimé avec succès'
        ]);
    }
}
