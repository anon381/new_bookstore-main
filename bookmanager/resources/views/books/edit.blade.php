<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
</head>
<body>
    <h1>Edit Book</h1>

    <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <label for="title">Title</label>
        <input type="text" name="title" value="{{ old('title', $book->title) }}" required>

        <label for="author">Author</label>
        <input type="text" name="author" value="{{ old('author', $book->author) }}" required>

        <label for="genre">Genre</label>
        <input type="text" name="genre" value="{{ old('genre', $book->genre) }}" required>

        <label for="year">Published Year</label>
        <input type="number" name="year" value="{{ old('year', $book->published_year) }}" required>

        <label for="cover">Cover Photo (Optional)</label>
        <input type="file" name="cover">

        <button type="submit">Update Book</button>
    </form>

    <a href="{{ route('books.index') }}">Back to List</a>
</body>
</html>
