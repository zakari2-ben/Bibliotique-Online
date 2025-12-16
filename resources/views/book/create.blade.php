<form method="POST" action="{{ route('book.store') }}">
    @csrf

    <input type="text" name="designation" placeholder="Titre">
    <textarea name="description"></textarea>
    <input type="number" name="prix">

    <button type="submit">Ajouter</button>
</form>
