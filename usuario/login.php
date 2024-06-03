<?php
include_once 'config/Database.php';
include_once 'classes/Usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

if ($_POST) {
    $usuario->username = $_POST['username'];
    $usuario->password = $_POST['password'];

    if ($usuario->login()) {
        session_start();
        $_SESSION['user_id'] = $usuario->id;
        header("Location: index.php");
    } else {
        echo "<div class='alert alert-danger'>Usuário ou senha incorretos.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Usuário:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <a href="register.php">Não tem uma conta? Registre-se</a>
    </div>
</body>
</html>