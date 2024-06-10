<?php
class Database {
    //Configuração banco de dados
    private $host = "localhost";
    private $db_name = "biblioteca";
    private $username = "root";
    private $password = "";
    public $conn;
     // Método para obter a conexão com o banco de dados
    public function getConnection() {
        $this->conn = null;
        try {
            // Cria uma nova conexão PDO
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            
            // Exibe mensagem de erro se a conexão falhar
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>