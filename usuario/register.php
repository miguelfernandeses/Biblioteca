<?php
include_once 'config/Database.php';
include_once 'classes/Usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

if ($_POST) {
    $usuario->username = $_POST['username'];
    $usuario->password = $_POST['password'];

    if ($usuario->register()) {
        echo "<div class='alert alert-success'>Usuário registrado com sucesso.</div>";
    } else {
        echo "<div class='alert alert-danger'>Não foi possível registrar o usuário.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Registro</h2>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="username">Usuário:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
        <a href="login.php">Já tem uma conta? Faça login</a>
    </div>
</body>
</html>