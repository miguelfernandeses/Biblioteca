<?php
class Livro {
    // Conexão com o banco de dados e nome da tabela
    private $conn;
    private $table_name = "livros";

    // Propriedades do livro
    public $id;
    public $titulo;
    public $id_autor;

    // Construtor que recebe a conexão com o banco de dados
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para ler todos os livros com paginação
    public function read($from_record_num, $records_per_page) {
        // Query para selecionar livros com limite e offset
        $query = "SELECT l.id, l.titulo, a.nome as autor_nome FROM " . $this->table_name . " l LEFT JOIN autores a ON l.id_autor = a.id LIMIT ?, ?";
        $stmt = $this->conn->prepare($query);

        // Vincula os parâmetros de limite e offset
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        // Executa a query
        $stmt->execute();
        return $stmt;
    }

    // Método para ler um único livro pelo ID
    public function readOne() {
        // Query para selecionar um livro pelo ID
        $query = "SELECT titulo, id_autor FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        // Vincula o parâmetro ID
        $stmt->bindParam(1, $this->id);

        // Executa a query
        $stmt->execute();

        // Obtém a linha de resultado
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Define as propriedades do livro
        $this->titulo = $row['titulo'];
        $this->id_autor = $row['id_autor'];
    }

    // Método para contar o número total de livros
    public function count() {
        // Query para contar o número total de linhas na tabela
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);

        // Executa a query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retorna o número total de linhas
        return $row['total_rows'];
    }

    // Método para criar um novo livro
    public function create() {
        // Query para inserir um novo livro
        $query = "INSERT INTO " . $this->table_name . " SET titulo=:titulo, id_autor=:id_autor";
        $stmt = $this->conn->prepare($query);

        // Limpa os dados
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->id_autor = htmlspecialchars(strip_tags($this->id_autor));

        // Vincula os parâmetros
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":id_autor", $this->id_autor);

        // Executa a query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para atualizar um livro existente
    public function update() {
        // Query para atualizar um livro
        $query = "UPDATE " . $this->table_name . " SET titulo = :titulo, id_autor = :id_autor WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Limpa os dados
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->id_autor = htmlspecialchars(strip_tags($this->id_autor));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincula os parâmetros
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':id_autor', $this->id_autor);
        $stmt->bindParam(':id', $this->id);

        // Executa a query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para excluir um livro
    public function delete() {
        // Query para excluir um livro pelo ID
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        // Limpa os dados
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincula o parâmetro ID
        $stmt->bindParam(1, $this->id);

        // Executa a query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>