<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Biblioteca</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo à Biblioteca</h1>
        <?php if (isset($_SESSION['user_id'])): ?>
            <p>Olá, usuário! <a href="logout.php" class="btn btn-danger">Logout</a></p>
            <a href="autores/index.php" class="btn btn-primary">Gerenciar Autores</a>
            <a href="livros/index.php" class="btn btn-primary">Gerenciar Livros</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-primary">Login</a>
            <a href="register.php" class="btn btn-primary">Registrar</a>
        <?php endif; ?>
    </div>
</body>
</html>