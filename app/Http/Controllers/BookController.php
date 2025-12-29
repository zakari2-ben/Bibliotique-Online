<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::latest()->get();

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
    public function store(StoreBookRequest $request)
{
    // Récupérer uniquement les données validées par le Form Request
    $validatedData = $request->validated();

    // Créer une nouvelle instance de Book avec les données validées
    // (à condition que les champs soient définis dans $fillable du modèle)
    $book = new Book($validatedData);

    // Ajouter les champs qui ne sont pas inclus dans la validation
    // (champs optionnels ou traités séparément)
    $book->editeur = $request->input('editeur');
    $book->annee = $request->input('annee');

    // Gestion de l’upload de l’image de couverture
    if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
        $image = $request->file('cover');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('covers'), $imageName);
        $book->cover = $imageName;
    } else {
        // Image par défaut si aucune couverture n’est fournie
        $book->cover = 'default-book.png';
    }

    // Enregistrer le livre dans la base de données
    $book->save();

    // Rediriger vers la liste des livres avec un message de succès
    return redirect()->route('book.index')
                     ->with('success', 'Livre ajouté avec succès.');
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
    // Tout d’abord, importer la Request


// ...

public function update(UpdateBookRequest $request, string $id)
{
    $book = Book::findOrFail($id);
    
    // Récupérer les données envoyées par l’utilisateur (sans l’image au départ)
    $data = $request->except('cover');

    // Vérifier si une nouvelle image a été envoyée
    if ($request->hasFile('cover') && $request->file('cover')->isValid()) {

        // (Optionnel) Supprimer l’ancienne image du serveur si ce n’est pas l’image par défaut
        if ($book->cover && $book->cover !== 'default-book.png') {
            $oldPath = public_path('covers/' . $book->cover);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Téléverser la nouvelle image
        $image = $request->file('cover');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('covers'), $imageName);
        
        // Ajouter le nom de la nouvelle image aux données à mettre à jour
        $data['cover'] = $imageName;
    }

    // Mettre à jour le livre avec les nouvelles données
    $book->update($data);

    return redirect()->route('book.index')
        ->with('success', 'Le livre a été modifié avec succès.');
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
