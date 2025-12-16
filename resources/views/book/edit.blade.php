<form method="POST" action="{{ route('book.update', $book->id) }}">
    @csrf
    @method('PUT')

    <input type="text" name="designation" value="{{ $book->designation }}">
    <textarea name="description">{{ $book->description }}</textarea>
    <input type="number" name="prix" value="{{ $book->prix }}">

    <button type="submit">Modifier</button>
</form>
