<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include 'db.php';


// Log to file
function logAction($action, $details) {
    $logEntry = date("Y-m-d H:i:s") . " - $action: $details\n";
    file_put_contents('log.txt', $logEntry, FILE_APPEND);
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'GET':
        $stmt = $pdo->query("SELECT * FROM books");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'POST':
        if (!empty($_POST['title'])) {
            $coverPath = null;

            // Upload and process image
            if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
                if (!is_dir('uploads')) mkdir('uploads');
                $image = imagecreatefromjpeg($_FILES['cover']['tmp_name']);
                $resized = imagescale($image, 300, 400);
                $white = imagecolorallocate($resized, 255, 255, 255);
                imagestring($resized, 5, 10, 10, 'MyBrand', $white);

                $fileName = uniqid() . ".jpg";
                $destination = "uploads/" . $fileName;
                imagejpeg($resized, $destination);
                imagedestroy($image);
                imagedestroy($resized);

                $coverPath = $destination;
            }

            $stmt = $pdo->prepare("INSERT INTO books (title, author, genre, published_year, cover_photo) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['title'],
                $_POST['author'],
                $_POST['genre'],
                $_POST['published_year'],
                $coverPath
            ]);
            logAction("Added", $_POST['title']);
            echo json_encode(["message" => "Book added"]);
        } else {
            echo json_encode(["error" => "Missing title"]);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            logAction("Deleted", "ID: " . $_GET['id']);
            echo json_encode(["message" => "Book deleted"]);
        } else {
            echo json_encode(["error" => "ID required"]);
        }
        break;

    default:
        echo json_encode(["error" => "Unsupported method"]);
}
?>
