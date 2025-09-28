<?php
require_once __DIR__ . "/../backend/books.php";

if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
    $bookObj = new Book();
    $bookObj->deleteBook($_GET['id']);
}

// After deleting, go back to the list
header("Location: view_books.php");
exit;
