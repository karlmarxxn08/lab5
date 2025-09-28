<?php
require_once __DIR__ . "/../backend/books.php";
$bookObj = new Book();

$book      = [];
$errors    = [];
$b_book_id = null;

/* --  GET: Load existing book data -- */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!empty($_GET['book_id']) && ctype_digit($_GET['book_id'])) {
        $b_book_id = (int) $_GET['book_id'];
        $book      = $bookObj->fetchBooks($b_book_id);
        if (!$book) {
            header("Location: view_books.php");
            exit;
        }
    } else {
        header("Location: view_books.php");
        exit;
    }
}

/* --  POST: Save changes -- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // keep id across postbacks
    $b_book_id = (int) ($_GET['book_id'] ?? $_POST['book_id'] ?? 0);

    // repopulate form values
    $book['book_title']       = trim($_POST['book_title'] ?? '');
    $book['book_author']      = trim($_POST['book_author'] ?? '');
    $book['genre']            = trim($_POST['genre'] ?? '');
    $book['publication_year'] = trim($_POST['publication_year'] ?? '');
    $book['book_price']       = trim($_POST['book_price'] ?? '');

    // validation
    if ($book['book_title'] === '')       $errors['book_title']       = 'Book Title is required';
    if ($book['book_author'] === '')      $errors['book_author']      = 'Book Author is required';
    if ($book['genre'] === '')            $errors['genre']            = 'Book genre is required';
    if ($book['publication_year'] === '' || !ctype_digit($book['publication_year']))
        $errors['publication_year']       = 'Valid Publication Year is required';
    if ($book['book_price'] === '' || !is_numeric($book['book_price']))
        $errors['book_price']             = 'Valid Book Price is required';

    if (!$errors) {
        // assign to object
        $bookObj->book_title       = $book['book_title'];
        $bookObj->book_author      = $book['book_author'];
        $bookObj->genre            = $book['genre'];
        $bookObj->publication_year = $book['publication_year'];
        $bookObj->book_price       = $book['book_price'];

        if ($bookObj->editBook($b_book_id)) {
            header("Location: edit_books.php");
            exit;
        } else {
            $errors['general'] = "Failed to save book.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="LIBRARY | EDIT BOOK">
    <title>Library | Edit Book</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/EDIT_books.css">
</head>
<body>
    <h1>Edit Book</h1>
    <p>Fields with <span>*</span> are required</p>

    <?php if (!empty($errors['general'])): ?>
        <p class="error"><?= htmlspecialchars($errors['general']) ?></p>
    <?php endif; ?>

    <form method="post">
        <!-- hidden id so POST knows which record to update -->
        <input type="hidden" name="book_id" value="<?= htmlspecialchars($b_book_id) ?>">

        <label for="book_title">Book Title <span>*</span></label>
        <input type="text" name="book_title" id="book_title"
               value="<?= htmlspecialchars($book['book_title'] ?? '') ?>">
        <p class="error"><?= $errors['book_title'] ?? '' ?></p>

        <label for="book_author">Book Author <span>*</span></label>
        <input type="text" name="book_author" id="book_author"
               value="<?= htmlspecialchars($book['book_author'] ?? '') ?>">
        <p class="error"><?= $errors['book_author'] ?? '' ?></p>

        <label for="genre">Genre <span>*</span></label>
        <select name="genre" id="genre">
            <option value="">--Select Genre--</option>
            <?php
            foreach (['fiction','history','science'] as $g) {
                $sel = ($book['genre'] ?? '') === $g ? 'selected' : '';
                echo "<option value=\"$g\" $sel>" . ucfirst($g) . "</option>";
            }
            ?>
        </select>
        <p class="error"><?= $errors['genre'] ?? '' ?></p>

        <label for="publication_year">Year of Publication <span>*</span></label>
        <input type="text" name="publication_year" id="publication_year"
               value="<?= htmlspecialchars($book['publication_year'] ?? '') ?>">
        <p class="error"><?= $errors['publication_year'] ?? '' ?></p>

        <label for="book_price">Price of the Book <span>*</span></label>
        <input type="number" step="0.01" name="book_price" id="book_price"
               value="<?= htmlspecialchars($book['book_price'] ?? '') ?>">
        <p class="error"><?= $errors['book_price'] ?? '' ?></p>

        <button type="submit">Save Book</button>
        <a href="view_books.php">Cancel</a>
    </form>
</body>
</html>
