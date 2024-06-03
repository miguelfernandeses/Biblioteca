<?php
class Livro {
    private $conn;
    private $table_name = "livros";

    public $id;
    public $titulo;
    public $id_autor;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read($from_record_num, $records_per_page) {
        $query = "SELECT l.id, l.titulo, a.nome as autor_nome FROM " . $this->table_name . " l LEFT JOIN autores a ON l.id_autor = a.id LIMIT ?, ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT titulo, id_autor FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->titulo = $row['titulo'];
        $this->id_autor = $row['id_autor'];
    }

    public function count() {
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows'];
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET titulo=:titulo, id_autor=:id_autor";
        $stmt = $this->conn->prepare($query);

        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->id_autor = htmlspecialchars(strip_tags($this->id_autor));

        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":id_autor", $this->id_autor);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET titulo = :titulo, id_autor = :id_autor WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->id_autor = htmlspecialchars(strip_tags($this->id_autor));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':id_autor', $this->id_autor);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>