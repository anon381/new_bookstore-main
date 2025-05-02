<!-- resources/views/books/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
</head>
<body>

    <h1>All Books</h1>
    <a href="{{ route('books.create') }}">Create New Book</a>

    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Cover</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>
                        @if($book->cover)
                            <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}" width="100">
                        @else
                            No cover image
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('books.edit', $book->id) }}">Edit</a>
                        <a href="{{ route('books.destroy', $book->id) }}" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
