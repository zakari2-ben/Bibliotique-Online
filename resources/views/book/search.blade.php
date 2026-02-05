<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Page de Recherche
        </h2>
    </x-slot>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold text-gray-900">Rechercher un Livre</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <!-- Left content (Filters) -->
            <aside class="col-span-1">
                <form action="{{ route('book.search') }}" method="GET" id="filterForm">
                    <!-- Garder la recherche actuelle -->
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    
                    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-md space-y-8">
                        <h4 class="text-xl font-semibold text-gray-800 border-b border-gray-200 pb-4">Filtrer les livres</h4>

                        <div>
                            <h5 class="font-semibold text-gray-800 mb-3">Categories</h5>
                            <select name="category" onchange="document.getElementById('filterForm').submit()"
                                class="w-full bg-gray-50 border border-gray-300 rounded-md text-gray-800 focus:ring-blue-500 focus:border-blue-500 text-sm p-2.5">
                                <option value="">Tout</option>
                                <option value="Informatique" {{ request('category') == 'Informatique' ? 'selected' : '' }}>Informatique</option>
                                <option value="Design" {{ request('category') == 'Design' ? 'selected' : '' }}>Design</option>
                                <option value="Marketing" {{ request('category') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="Documentaires" {{ request('category') == 'Documentaires' ? 'selected' : '' }}>Documentaires</option>
                                <option value="Poésie" {{ request('category') == 'Poésie' ? 'selected' : '' }}>Poésie</option>
                                <option value="Mangas" {{ request('category') == 'Mangas' ? 'selected' : '' }}>Mangas</option>
                            </select>
                        </div>

                        <div>
                            <h5 class="font-semibold text-gray-800 mb-3">Type</h5>
                            <div class="space-y-2">
                                <label class="flex items-center text-gray-600">
                                    <input type="checkbox" name="type[]" value="Texte" 
                                        {{ in_array('Texte', request('type', [])) ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit()"
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2">Texte</span>
                                </label>
                                <label class="flex items-center text-gray-600">
                                    <input type="checkbox" name="type[]" value="Audible"
                                        {{ in_array('Audible', request('type', [])) ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit()"
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2">Audible</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <h5 class="font-semibold text-gray-800 mb-3">Tags</h5>
                            <div class="space-y-2">
                                <label class="flex items-center text-gray-600">
                                    <input type="checkbox" name="tags[]" value="HTML"
                                        {{ in_array('HTML', request('tags', [])) ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit()"
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2">HTML</span>
                                </label>
                                <label class="flex items-center text-gray-600">
                                    <input type="checkbox" name="tags[]" value="Laravel"
                                        {{ in_array('Laravel', request('tags', [])) ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit()"
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2">Laravel</span>
                                </label>
                            </div>
                        </div>

                        <div class="pt-4">
                            <a href="{{ route('book.search') }}" class="w-full inline-block text-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Réinitialiser les filtres
                            </a>
                        </div>
                    </div>
                </form>
            </aside>

            <!-- Right content (Book List) -->
            <div class="col-span-1 lg:col-span-3">
                <div class="flex items-center justify-between mb-6 bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                    <span class="text-gray-600">{{ $books->total() }} Livres trouvés</span>
                    <form action="{{ route('book.search') }}" method="GET" class="flex items-center">
                        <!-- Garder tous les filtres actuels -->
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        @foreach(request('type', []) as $type)
                            <input type="hidden" name="type[]" value="{{ $type }}">
                        @endforeach
                        @foreach(request('tags', []) as $tag)
                            <input type="hidden" name="tags[]" value="{{ $tag }}">
                        @endforeach
                        
                        <span class="text-gray-600 mr-2">Trier par:</span>
                        <select name="sort" onchange="this.form.submit()"
                            class="bg-gray-50 border border-gray-300 rounded-md text-gray-800 focus:ring-blue-500 focus:border-blue-500 text-sm p-2">
                            <option value="">Récent</option>
                            <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Date</option>
                            <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Prix</option>
                            <option value="titre" {{ request('sort') == 'titre' ? 'selected' : '' }}>Titre</option>
                        </select>
                    </form>
                </div>

                @if($books->count() > 0)
                    <div class="space-y-6">
                        @foreach($books as $book)
                            <div class="bg-white rounded-lg p-4 flex items-center justify-between border border-gray-200 shadow-sm hover:shadow-lg transition">
                                <div class="flex items-center">
                                    <img src="{{ asset('covers/' . $book->cover) }}" alt="{{ $book->designation }}"
                                        class="w-20 h-28 object-cover rounded-md mr-4">
                                    <div>
                                        <a href="{{ route('book.show', $book->id) }}" class="text-lg font-semibold text-gray-900 hover:text-blue-600">
                                            {{ $book->designation }}
                                        </a>
                                        <ul class="flex flex-wrap gap-x-4 text-sm text-gray-500 mt-1">
                                            <li>{{ $book->category }}</li>
                                            <li>{{ $book->tags }}</li>
                                            <li>par {{ $book->auteur }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('book.show', $book->id) }}" class="text-blue-600 hover:underline">Détails</a>
                                    <span class="block text-lg font-semibold text-gray-900 mt-1">{{ $book->prix }} DH</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $books->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-lg p-8 text-center border border-gray-200 shadow-sm">
                        <p class="text-gray-600 text-lg">Aucun livre trouvé avec ces critères de recherche.</p>
                        <a href="{{ route('book.search') }}" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Réinitialiser la recherche
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>