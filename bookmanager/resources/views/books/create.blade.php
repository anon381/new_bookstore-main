<!-- resources/views/books/create.blade.php -->
<h1>Create a New Book</h1>
<form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
    </div>
    <div>
        <label for="author">Author:</label>
        <input type="text" name="author" id="author" required>
    </div>
    <div>
        <label for="cover">Cover Image:</label>
        <input type="file" name="cover" id="cover" required>
    </div>
    <button type="submit">Create Book</button>
</form>
