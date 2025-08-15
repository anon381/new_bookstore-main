<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = DB::table('books')->get();
        return view('welcome', ['books' => $books, 'editMode' => false, 'editBook' => null]);
    }

    public function store(Request $request)
    {
                $books = DB::table('books')->get();
        // request-validation
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'genre' => 'required|string',
            'year' => 'required|integer',
            'cover' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $coverPath = $request->file('cover')->store('uploads', 'public');

        DB::table('books')->insert([
            'title' => $request->title,
            'author' => $request->author,
            'genre' => $request->genre,
            'published_year' => $request->year,
            'cover_photo' => 'storage/' . $coverPath,
        ]);
       $this->logAction("Book added: {$request->title}");

return redirect()->route('books.index')->with('success', 'Book added successfully');    }

    public function edit($id)
    {
        $editBook = DB::table('books')->where('id', $id)->first();
        $books = DB::table('books')->get();
        
        return view('welcome', ['editMode' => true, 'editBook' => $editBook, 'books' => $books]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'genre' => 'required|string',
            'year' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $book = DB::table('books')->where('id', $id)->first();

        $coverPath = $book->cover_photo;

        if ($request->hasFile('cover')) {
            if ($coverPath && file_exists(public_path($coverPath))) {
                unlink(public_path($coverPath));
            }

            $newPath = $request->file('cover')->store('uploads', 'public');
            $coverPath = 'storage/' . $newPath;
        }

        DB::table('books')->where('id', $id)->update([
            'title' => $data['title'],
            'author' => $data['author'],
            'genre' => $data['genre'],
            'published_year' => $data['year'],
            'cover_photo' => $coverPath,
        ]);
$this->logAction("Book updated: {$book->title}");

        return redirect()->route('books.index');
    }

    public function destroy($id)
    {
        $book = DB::table('books')->where('id', $id)->first();

        if ($book->cover_photo && file_exists(public_path($book->cover_photo))) {
            unlink(public_path($book->cover_photo));
        }

        DB::table('books')->where('id', $id)->delete();
$this->logAction("Book deleted: {$book->title}");

        return redirect()->route('books.index');
    }
    private function logAction($message)
{
    $date = now()->format('Y-m-d H:i:s');
    $logMessage = "[$date] $message" . PHP_EOL;
    file_put_contents(storage_path('logs/log.txt'), $logMessage, FILE_APPEND);
}

}
?>
