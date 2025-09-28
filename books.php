<?php
require_once "database.php";

class Book extends Database {
    public $book_id       = "";
    public $book_title    = "";
    public $book_author   = "";
    public $genre         = "";
    public $publication_year = "";
    public $book_price    = "";
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    /* -- CREATE FUNCTION -- */
    public function addBook() {
        $sql = "INSERT INTO books 
                   (book_title, book_author, genre, publication_year, book_price)
                VALUES 
                   (:book_title, :book_author, :genre, :publication_year, :book_price)";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(":book_title",       $this->book_title);
        $query->bindParam(":book_author",      $this->book_author);
        $query->bindParam(":genre",            $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);
        $query->bindParam(":book_price",       $this->book_price);
        return $query->execute();
    }

    /* -- READ FUNCTION -- */
    public function viewBook() {
        $sql = "SELECT * FROM books ORDER BY book_title ASC";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchBooks($id) {
        $sql = "SELECT * FROM books WHERE book_id = :book_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(":book_id", $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /* -- UPDATE FUNCTION -- */
    public function editBook($id) {
        $sql = "UPDATE books 
                   SET book_title = :book_title,
                       book_author = :book_author,
                       genre = :genre,
                       publication_year = :publication_year,
                       book_price = :book_price
                 WHERE book_id = :book_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(":book_title",       $this->book_title);
        $query->bindParam(":book_author",      $this->book_author);
        $query->bindParam(":genre",            $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);
        $query->bindParam(":book_price",       $this->book_price);
        $query->bindParam(":book_id",          $id, PDO::PARAM_INT);
        return $query->execute();
    }

    /* -- DELETE FUNCTION -- */
    public function deleteBook($id) {
        $sql = "DELETE FROM books WHERE book_id = :book_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(":book_id", $id, PDO::PARAM_INT);
        return $query->execute();
    }

    /* -- SEARCH FUNCTION -- */
    public function searchBook($keyword) {
        $sql = "SELECT * FROM books
                WHERE book_title  LIKE :kw
                   OR book_author LIKE :kw
                   OR genre       LIKE :kw
                ORDER BY book_title ASC";
        $query = $this->db->connect()->prepare($sql);
        $like = "%".$keyword."%";
        $query->bindParam(":kw", $like, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* -- DUPLICATE CHECK FUNCTION -- */
    public function isBookExists($title, $exclude_id = null) {
        $sql = "SELECT COUNT(*) FROM books WHERE book_title = :title";
        if ($exclude_id) {
            $sql .= " AND book_id <> :exclude_id";
        }
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':title', $title);
        if ($exclude_id) {
            $query->bindParam(':exclude_id', $exclude_id, PDO::PARAM_INT);
        }
        $query->execute();
        return $query->fetchColumn() > 0;
    }
}
