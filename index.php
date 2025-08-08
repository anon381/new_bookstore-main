<?php
$pdo = new PDO("mysql:host=localhost;dbname=bookstore", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if editing
$editMode = false;
$editBook = null;

if (isset($_GET['edit'])) {
    $editMode = true;
    $editId = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->execute([$editId]);
    $editBook = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle Add / Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title  = $_POST['title'];
    $author = $_POST['author'];
    $genre  = $_POST['genre'];
    $year   = $_POST['year'];
    $coverPath = null;

    $isUpdate = isset($_POST['update']);
    $bookId = $_POST['book_id'] ?? null;

    // Handle image if uploaded
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['cover']['tmp_name'];
        $fileType = mime_content_type($fileTmp);

        if (in_array($fileType, ['image/jpeg', 'image/png'])) {
            $ext = $fileType === 'image/png' ? '.png' : '.jpg';
            $newName = 'uploads/' . uniqid() . $ext;

            $src = $fileType === 'image/jpeg' ? imagecreatefromjpeg($fileTmp) : imagecreatefrompng($fileTmp);
            $resized = imagescale($src, 300, 400);

            $white = imagecolorallocate($resized, 255, 255, 255);
            imagestring($resized, 5, 10, 10, 'MyBrand', $white);

            if ($fileType === 'image/jpeg') {
                imagejpeg($resized, $newName);
            } else {
                imagepng($resized, $newName);
            }

            imagedestroy($src);
            imagedestroy($resized);

            $coverPath = $newName;
        }
    }

    if ($isUpdate && $bookId) {
        if ($coverPath) {
            // Delete old cover
            $old = $pdo->prepare("SELECT cover_photo FROM books WHERE id = ?");
            $old->execute([$bookId]);
            $oldCover = $old->fetchColumn();
            if ($oldCover && file_exists($oldCover)) {
                unlink($oldCover);
            }

            $stmt = $pdo->prepare("UPDATE books SET title=?, author=?, genre=?, published_year=?, cover_photo=? WHERE id=?");
            $stmt->execute([$title, $author, $genre, $year, $coverPath, $bookId]);
        } else {
            $stmt = $pdo->prepare("UPDATE books SET title=?, author=?, genre=?, published_year=? WHERE id=?");
            $stmt->execute([$title, $author, $genre, $year, $bookId]);
        }

        file_put_contents("log.txt", date("Y-m-d H:i:s") . " - Updated: $title\n", FILE_APPEND);
    } else {
        $stmt = $pdo->prepare("INSERT INTO books (title, author, genre, published_year, cover_photo) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $author, $genre, $year, $coverPath]);

        file_put_contents("log.txt", date("Y-m-d H:i:s") . " - Added: $title\n", FILE_APPEND);
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $stmt = $pdo->prepare("SELECT cover_photo FROM books WHERE id = ?");
    $stmt->execute([$deleteId]);
    $cover = $stmt->fetchColumn();
    if ($cover && file_exists($cover)) {
        unlink($cover);
    }

    $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
    $stmt->execute([$deleteId]);

    file_put_contents("log.txt", date("Y-m-d H:i:s") . " - Deleted book ID: $deleteId\n", FILE_APPEND);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Manager</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            color: #333;
            padding: 20px;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 600px;
            margin-bottom: 40px;
        }
        input, button {
            width: 90%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        input:focus {
            border-color: #3498db;
            outline: none;
        }
        button {
            background: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #2980b9;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #444;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-radius: 12px;
            overflow: hidden;
        }
        th {
            background-color: #2c3e50;
            color: white;
            padding: 15px;
            text-align: left;
        }
        td {
            padding: 15px;
            border-top: 1px solid #eee;
        }
        tr:hover {
            background-color: #f0f8ff;
        }
        img {
            height: 100px;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }
        img:hover {
            transform: scale(1.1);
        }
        a {
            text-decoration: none;
            margin-right: 10px;
            color: #3498db;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2><?= $editMode ? "Edit Book" : "Add a New Book" ?></h2>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="book_id" value="<?= $editBook['id'] ?? '' ?>">

    <label>Title</label>
    <input name="title" value="<?= htmlspecialchars($editBook['title'] ?? '') ?>" required>

    <label>Author</label>
    <input name="author" value="<?= htmlspecialchars($editBook['author'] ?? '') ?>" required>

    <label>Genre</label>
    <input name="genre" value="<?= htmlspecialchars($editBook['genre'] ?? '') ?>" required>

    <label>Year</label>
    <input name="year" type="number" value="<?= htmlspecialchars($editBook['published_year'] ?? '') ?>" required>

    <label>Cover Image <?= $editMode ? "(leave blank to keep existing)" : "" ?></label>
    <input type="file" name="cover" accept=".jpg,.jpeg,.png" <?= $editMode ? '' : 'required' ?>>

    <button type="submit" name="<?= $editMode ? 'update' : 'add' ?>">
        <?= $editMode ? 'Update Book' : 'Add Book' ?>
    </button>
</form>

<h2>All Books</h2>
<table>
    <tr>
        <th>ID</th><th>Title</th><th>Author</th><th>Genre</th><th>Year</th><th>Cover</th><th>Actions</th>
    </tr>
    <?php
    $books = $pdo->query("SELECT * FROM books")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($books as $book):
    ?>
    <tr>
        <td><?= htmlspecialchars($book['id']) ?></td>
        <td><?= htmlspecialchars($book['title']) ?></td>
        <td><?= htmlspecialchars($book['author']) ?></td>
        <td><?= htmlspecialchars($book['genre']) ?></td>
        <td><?= htmlspecialchars($book['published_year']) ?></td>
        <td>
            <?php if ($book['cover_photo']): ?>
                <img src="<?= htmlspecialchars($book['cover_photo']) ?>" alt="Cover">
            <?php else: ?>
                No-cover yet
            <?php endif; ?>
        </td>
        <td>
            <a href="?edit=<?= $book['id'] ?>">✏️ Edit</a>
            <a href="?delete=<?= $book['id'] ?>" onclick="return confirm('Delete this book?')">🗑 Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
