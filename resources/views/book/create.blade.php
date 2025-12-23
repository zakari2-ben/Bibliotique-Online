@extends('layouts.app')

@section('title', 'Ajouter un nouveau livre')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mx-auto text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Ajouter un nouveau livre</h2>
            <p class="mt-2 text-gray-600">عمر المعلومات لتحت باش تزيد كتاب جديد للمكتبة ديالك.</p>
        </div>

        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <form action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Désignation (العنوان)</label>
                        <input type="text" name="designation" value="{{ old('designation') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border @error('designation') border-red-500 @enderror">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Auteur (الكاتب)</label>
                        <input type="text" name="auteur" value="{{ old('auteur') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border @error('auteur') border-red-500 @enderror">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Editeur (الناشر)</label>
                        <input type="text" name="editeur" value="{{ old('editeur') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Année (السنة)</label>
                        <input type="number" name="annee" value="{{ old('annee') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prix (الثمن)</label>
                        <input type="number" step="0.01" name="prix" value="{{ old('prix') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border @error('prix') border-red-500 @enderror">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Catégorie / Type (النوع)</label>
                        <input type="text" name="type" value="{{ old('type') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border @error('type') border-red-500 @enderror">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Description (وصف الكتاب)</label>
                        <textarea name="description" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Image de couverture (صورة الغلاف)</label>
                        <div class="mt-1 flex items-center">
                            <input type="file" name="cover" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Formats acceptés: JPG, PNG, GIF (Max 2MB)</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('book.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-800">Annuler</a>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Enregistrer le livre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection