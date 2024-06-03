<?php
include_once '../config/Database.php';
include_once '../classes/Autor.php';

$database = new Database();
$db = $database->getConnection();

$autor = new Autor($db);

$autor->id = isset($_GET['id']) ? $_GET['id'] : die('ID não encontrado.');

if ($autor->delete()) {
    echo "Autor excluído com sucesso.";
} else {
    echo "Não foi possível excluir o autor.";
}
?>
<a href="index.php">Voltar</a>