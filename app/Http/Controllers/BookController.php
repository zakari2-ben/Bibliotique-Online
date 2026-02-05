<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{

    // Display a listing of the resource.

    public function index()
    {
        try {
            $books = Book::latest()->paginate(15);
            Log::info('fetch books successfly');
            return view('book.index', compact('books'));
        } catch (\Exception $e) {
            Log::error('error fetching books' . $e->getMessage());
        }
    }


    // Show the form for creating a new resource.

    public function create()
    {
        return view('book.create');
    }


    // Store a newly created resource in storage.

    public function store(StoreBookRequest $request)
    {
        try {

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
            Log::info('New book created : id ' . $book->id . '-title:' . $book->designation);

            // Rediriger vers la liste des livres avec un message de succès
            return redirect()->route('book.index')
                ->with('success', 'Livre ajouté avec succès.');
        } catch (\Exception $e) {
            Log::error('Failed to store book: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de l\'ajoute du livre.');
        }
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
        try {


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
                Log::info('cover removed for book id : ' . $id);
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
                Log::info('new cover uploaded for book id : ' . $id);
            }

            // Mettre à jour le livre avec les données validées et les éventuelles modifications de l’image
            $book->update($data);
            Log::info('Book updated successfully where id : ' . $id);

            // Rediriger vers la liste des livres avec un message de succès
            return redirect()->route('book.index')
                ->with('success', 'Le livre a été modifié avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la modification du livre. ');
        }
    }

    // Remove the specified resource from storage.

    public function destroy(string $id)
    {
        try {
            // 1. Rechercher le livre à supprimer à partir de son identifiant
            $book = Book::findOrFail($id);

            // 2. Supprimer l’image de couverture du serveur
            // (uniquement si elle existe et si ce n’est pas l’image par défaut)
            if ($book->cover && $book->cover !== 'default-book.png') {
                $imagePath = public_path('covers/' . $book->cover);
                if (file_exists($imagePath)) {
                    unlink($imagePath);

                    // Enregistrer dans les logs la suppression de l’image
                    Log::info('Cover image deleted from server for book ID: ' . $id);
                }
            }

            // 3. Supprimer le livre de la base de données
            $book->delete();

            // 4. Enregistrer dans les logs la suppression réussie du livre
            Log::info('Book deleted successfully: ID ' . $id . ' - Title: ' . $book->designation);

            return redirect()->route('book.index')
                ->with('success', 'Le livre a été supprimé avec succès.');
        } catch (\Exception $e) {
            // Enregistrer l’erreur dans les logs en cas de problème
            // (par exemple si le livre n’existe pas ou erreur serveur)
            Log::error('Error deleting book ID ' . $id . ': ' . $e->getMessage());

            return redirect()->route('book.index')
                ->with('error', 'Erreur lors de la suppression du livre.');
        }
    }

    // fonctione pour la recherche : 
    public function search(Request $request)
    {
        try {
            $query = Book::query();

            // Recherche par titre ou mot-clé
            if ($request->filled('search')) {
                $query->where('designation', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhere('auteur', 'like', '%' . $request->search . '%');
            }

            // Filtre par catégorie
            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            // Filtre par type (livre_type)
            if ($request->filled('type')) {
                $query->whereIn('livre_type', $request->type);
            }

            // Filtre par tags
            if ($request->filled('tags')) {
                foreach ($request->tags as $tag) {
                    $query->where('tags', 'like', '%' . $tag . '%');
                }
            }

            // Tri
            if ($request->filled('sort')) {
                switch ($request->sort) {
                    case 'date':
                        $query->latest();
                        break;
                    case 'price':
                        $query->orderBy('prix', 'asc');
                        break;
                    case 'titre':
                        $query->orderBy('designation', 'asc');
                        break;
                    default:
                        $query->latest();
                }
            } else {
                $query->latest();
            }

            $books = $query->paginate(10)->withQueryString();

            Log::info('Search executed successfully');

            return view('book.search', compact('books'));
        } catch (\Exception $e) {
            Log::error('Error in search: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la recherche.');
        }
    }
}
