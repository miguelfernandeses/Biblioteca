<?php
// Inclui os arquivos de configuração do banco de dados e a classe Livro
include_once '../config/Database.php';
include_once '../classes/Livro.php';

// Cria uma nova instância da classe Database e obtém a conexão
$database = new Database();
$db = $database->getConnection();

// Cria uma nova instância da classe Livro
$livro = new Livro($db);

// Obtém o ID do livro a ser excluído
$livro->id = isset($_GET['id']) ? $_GET['id'] : die('ID não encontrado.');

// Tenta excluir o livro
if ($livro->delete()) {
    echo "Livro excluído com sucesso.";
} else {
    echo "Não foi possível excluir o livro.";
}
?>
<a href="index.php">Voltar</a>