<?php
require_once __DIR__ . "/../backend/books.php";
$bookObj = new Book();

$search = '';
$books  = [];

if (isset($_GET['q']) && trim($_GET['q']) !== '') {
    $search = trim($_GET['q']);
    $books  = $bookObj->searchBook($search);
} else {
    $books  = $bookObj->viewBook();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="LIBRARY | VIEW BOOKS">
    <title>Library | View Books</title>
    <link rel="stylesheet" href="css/common.css"> 
    <link rel="stylesheet" href="css/view_books.css">
</head>
<body>
    <h1>List of Books</h1>

    <form method="get" action="">
        <input type="text" name="q" placeholder="Search books..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>
    <br>

    <button><a href="add_books.php">Add Book</a></button>

    <table border="1">
        <tr>
            <th>Book Title</th>
            <th>Book Author</th>
            <th>Book Genre</th>
            <th>Publication Year</th>
            <th>Book Price</th>
        </tr>
        <?php if (count($books) > 0): ?>
            <?php foreach ($books as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['book_title']) ?></td>
                    <td><?= htmlspecialchars($row['book_author']) ?></td>
                    <td><?= htmlspecialchars($row['genre']) ?></td>
                    <td><?= htmlspecialchars($row['publication_year']) ?></td>
                    <td><?= htmlspecialchars($row['book_price']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">No books found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
