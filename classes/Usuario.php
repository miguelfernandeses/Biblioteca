<?php
class Usuario {
    // Conexão com o banco de dados e nome da tabela
    private $conn;
    private $table_name = "usuarios";

    // Propriedades do usuário
    public $id;
    public $username;
    public $password;

    // Construtor que recebe a conexão com o banco de dados
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar um novo usuário
    public function register() {
        // Query para inserir um novo usuário
        $query = "INSERT INTO " . $this->table_name . " SET username=:username, password=:password";
        $stmt = $this->conn->prepare($query);

        // Limpa os dados
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = password_hash(htmlspecialchars(strip_tags($this->password)), PASSWORD_BCRYPT);

        // Vincula os parâmetros
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);

        // Executa a query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para fazer login
    public function login() {
        // Query para selecionar o usuário pelo nome de usuário
        $query = "SELECT id, password FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);

        // Limpa os dados
        $this->username = htmlspecialchars(strip_tags($this->username));

        // Vincula o parâmetro username
        $stmt->bindParam(":username", $this->username);

        // Executa a query
        $stmt->execute();

        // Verifica se o usuário existe
        if ($stmt->rowCount() > 0) {
            // Obtém a linha de resultado
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica a senha
            if (password_verify($this->password, $row['password'])) {
                // Define a propriedade id do usuário
                $this->id = $row['id'];
                return true;
            }
        }
        return false;
    }
}
?>