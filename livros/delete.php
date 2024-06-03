<?php
include_once '../config/Database.php';
include_once '../classes/Livro.php';

$database = new Database();
$db = $database->getConnection();

$livro = new Livro($db);

$livro->id = isset($_GET['id']) ? $_GET['id'] : die('ID não encontrado.');

if ($livro->delete()) {
    echo "Livro excluído com sucesso.";
} else {
    echo "Não foi possível excluir o livro.";
}
?>
<a href="index.php">Voltar</a>