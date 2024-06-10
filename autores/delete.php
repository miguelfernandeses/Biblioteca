<?php
// Inclui os arquivos de configuração do banco de dados e a classe Autor
include_once '../config/Database.php';
include_once '../classes/Autor.php';

// Cria uma nova instância da classe Database e obtém a conexão
$database = new Database();
$db = $database->getConnection();

// Cria uma nova instância da classe Autor
$autor = new Autor($db);

// Obtém o ID do autor a ser excluído
$autor->id = isset($_GET['id']) ? $_GET['id'] : die('ID não encontrado.');

// Tenta excluir o autor
if ($autor->delete()) {
    echo "Autor excluído com sucesso.";
} else {
    echo "Não foi possível excluir o autor.";
}
?>
<a href="index.php">Voltar</a>