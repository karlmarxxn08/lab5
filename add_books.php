<?php
require_once __DIR__ . "/../backend/books.php";
$bookObj = new Book();

$book = ["book_title"=>"","book_author"=>"","genre"=>"","publication_year"=>"", "book_price"=>""];
$errors = ["book_title"=>"","book_author"=>"","genre"=>"","publication_year"=>"", "book_price"=>""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book["book_title"] = trim(htmlspecialchars($_POST["book_title"]));
    $book["book_author"] = trim(htmlspecialchars($_POST["book_author"]));
    $book["genre"] = trim(htmlspecialchars($_POST["genre"]));
    $book["publication_year"] = trim(htmlspecialchars($_POST["publication_year"]));
    $book["book_price"] = trim(htmlspecialchars($_POST["book_price"]));


    if (empty($book["book_title"])) {
        $errors["book_title"] = "Book Title is required";
    }

    if (empty($book["book_author"])) {
        $errors["book_author"] = "Book Author is required";
    }

    if (empty($book["genre"])) {
        $errors["genre"] = "Book genre is required";
    }

    if (empty($book["publication_year"])) {
        $errors["publication_year"] = "Book's Publication Year is required";
    }

     if (empty($book["book_price"])) {
        $errors["book_price"] = "Book's Price is required";
    }

    if (empty(array_filter($errors))) {
        $bookObj->book_title = $book["book_title"];
        $bookObj->book_author = $book["book_author"];
        $bookObj->genre = $book["genre"];
        $bookObj->publication_year = $book["publication_year"];
        $bookObj->book_price = $book["book_price"];

        if ($bookObj->addBook()) {
            header("Location: view_books.php");
            exit;
        } else {
            echo "Failed to save book.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="LIBRARY | ADD BOOK">
    <title>LIBRARY | ADD BOOK</title>
    <link rel="stylesheet" href="css/common.css"> 
    <link rel="stylesheet" href="css/add_books.css">
</head>
<body>
    <h1>Add Book</h1>
    <p>Fields with <span>*</span> are required</p>

    <form method="post">
        <label for="book_title">Book Title <span>*</span></label>
        <input type="text" name="book_title" id="book_title" value="<?= $book["book_title"] ?>">
        <p class="error"><?= $errors["book_title"] ?></p>

        <label for="book_author">Book Author <span>*</span></label>
        <input type="text" name="book_author" id="book_author" value="<?= $book["book_author"] ?>">
        <p class="error"><?= $errors["book_author"] ?></p>

        <label for="genre">Genre <span>*</span></label>
        <select name="genre" id="genre">
            <option value="">--Select Genre--</option>
            <option value="fiction" <?= $book["genre"]=="fiction"?"selected":"" ?>>Fiction</option>
            <option value="history" <?= $book["genre"]=="history"?"selected":"" ?>>History</option>
            <option value="science" <?= $book["genre"]=="science"?"selected":"" ?>>Science</option>
        </select>
        <p class="error"><?= $errors["genre"] ?></p>

        <label for="publication_year">Year of Publication <span>*</span></label>
        <input type="text" name="publication_year" id="publication_year" value="<?= $book["publication_year"] ?>">
        <p class="error"><?= $errors["publication_year"] ?></p>
        <br>
        <label for="book_price">Price of the Book<span>*</span></label>
        <input type="number" name="book_price" id="book_price" value="<?= $book["book_price"] ?>" step="0.01">
        <br>
        <br>
        <button type="submit">Save Book</button>    
    </form>
</body>
</html>
