<?php
include_once '../config/Database.php';
include_once '../classes/Autor.php';

function validate($data) {
    $errors = [];

    if (empty($data['nome'])) {
        $errors[] = "Nome é obrigatório.";
    }

    if (empty($data['email'])) {
        $errors[] = "Email é obrigatório.";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email inválido.";
    }

    return $errors;
}

$database = new Database();
$db = $database->getConnection();

$autor = new Autor($db);

if ($_POST) {
    $errors = validate($_POST);

    if (empty($errors)) {
        $autor->nome = $_POST['nome'];
        $autor->email = $_POST['email'];

        if ($autor->create()) {
            echo "<div class='alert alert-success'>Autor criado com sucesso.</div>";
        } else {
            echo "<div class='alert alert-danger'>Não foi possível criar o autor.</div>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>{$error}</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Autor</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Adicionar Autor</h2>
        <form action="create.php" method="post">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
</body>
</html>