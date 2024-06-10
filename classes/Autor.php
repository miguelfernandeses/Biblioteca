<?php
class Autor {
    // Conexão com o banco de dados e nome da tabela
    private $conn;
    private $table_name = "autores";

    // Propriedades do autor
    public $id;
    public $nome;
    public $email;

    // Construtor que recebe a conexão com o banco de dados
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para ler todos os autores com paginação
    public function read($from_record_num, $records_per_page) {
        // Query para selecionar autores com limites de paginação
        $query = "SELECT * FROM " . $this->table_name . " LIMIT ?, ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Método para ler todos os autores sem paginação
    public function readAll() {
        // Query para selecionar todos os autores
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Método para ler um autor específico
    public function readOne() {
        // Query para selecionar um autor pelo ID
        $query = "SELECT nome, email FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        // Obtém os dados do autor
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->nome = $row['nome'];
        $this->email = $row['email'];
    }

    // Método para contar o número total de autores
    public function count() {
        // Query para contar o número total de autores
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows'];
    }

    // Método para criar um novo autor
    public function create() {
        // Query para inserir um novo autor
        $query = "INSERT INTO " . $this->table_name . " SET nome=:nome, email=:email";
        $stmt = $this->conn->prepare($query);

        // Limpa os dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Vincula os parâmetros
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);

        // Executa a query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para atualizar um autor existente
    public function update() {
        // Query para atualizar um autor
        $query = "UPDATE " . $this->table_name . " SET nome = :nome, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Limpa os dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincula os parâmetros
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':id', $this->id);

        // Executa a query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para excluir um autor e seus livros associados
    public function delete() {
        // Excluir livros associados
        $query = "DELETE FROM livros WHERE id_autor = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        // Excluir autor
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        // Executa a query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>