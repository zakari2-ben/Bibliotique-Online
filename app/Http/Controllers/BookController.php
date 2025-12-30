<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    
    // Display a listing of the resource.
    
    public function index()
    {
        $books = Book::latest()->paginate(15);

        return view('book.index', compact('books'));
    }

    
    // Show the form for creating a new resource.
    
    public function create()
    {
        return view('book.create');
    }

    
    // Store a newly created resource in storage.
    
    public function store(StoreBookRequest $request)
    {
        // Récupérer uniquement les données validées par le Form Request
        $validatedData = $request->validated();

        // Créer une nouvelle instance de Book avec les données validées
        // (à condition que les champs soient définis dans $fillable du modèle)
        $book = new Book($validatedData);

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


    
    
    public function show(string $id)
    {
        $book = Book::findOrFail($id);
        return view('book.show', compact('book'));
    }

    
    // Show the form for editing the specified resource.
    
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        return view('book.edit', compact('book'));
    }


    // Update the specified resource in storage.

    public function update(UpdateBookRequest $request, string $id)
    {
        // Récupérer le livre à modifier depuis la base de données
        // Si l’ID n’existe pas, Laravel retourne automatiquement une erreur 404
        $book = Book::findOrFail($id);

        // Récupérer uniquement les données validées par le Form Request
        $data = $request->validated();

        // 1. Logique de suppression de la couverture si l’option "remove_cover" est cochée
        // Cette condition permet de réinitialiser l’image vers l’image par défaut
        if ($request->has('remove_cover') && $book->cover !== 'default-book.png') {
            $oldPath = public_path('covers/' . $book->cover);

            // Vérifier que l’image existe avant de la supprimer du serveur
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            // Mettre à jour la valeur de la couverture avec l’image par défaut
            $data['cover'] = 'default-book.png';
        }

        // 2. Logique de téléversement d’une nouvelle image
        // Si une nouvelle image est envoyée, elle remplace automatiquement l’ancienne
        // (et annule implicitement l’option remove_cover)
        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {

            // Supprimer l’ancienne image si elle existe et si ce n’est pas l’image par défaut
            if ($book->cover && $book->cover !== 'default-book.png') {
                $oldPath = public_path('covers/' . $book->cover);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Récupérer la nouvelle image envoyée par l’utilisateur
            $image = $request->file('cover');

            // Générer un nom unique pour éviter les conflits de fichiers
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Déplacer l’image vers le dossier public/covers
            $image->move(public_path('covers'), $imageName);

            // Mettre à jour la valeur de la couverture dans les données à sauvegarder
            $data['cover'] = $imageName;
        }

        // Mettre à jour le livre avec les données validées et les éventuelles modifications de l’image
        $book->update($data);

        // Rediriger vers la liste des livres avec un message de succès
        return redirect()->route('book.index')
            ->with('success', 'Le livre a été modifié avec succès.');
    }




    
    // Remove the specified resource from storage.
    
    public function destroy(string $id)
    {
        Book::findOrFail($id)->delete();
        return redirect()->route('book.index')->with('success', 'Le livre a été supremeé avec succès.');
    }
}
