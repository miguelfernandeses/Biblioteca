<?php
include_once '../config/Database.php';
include_once '../classes/Livro.php';
include_once '../classes/Autor.php';

function validate($data) {
    $errors = [];

    if (empty($data['titulo'])) {
        $errors[] = "Título é obrigatório.";
    }

    if (empty($data['id_autor'])) {
        $errors[] = "Autor é obrigatório.";
    }

    return $errors;
}

$database = new Database();
$db = $database->getConnection();

$livro = new Livro($db);
$autor = new Autor($db);

if ($_POST) {
    $errors = validate($_POST);

    if (empty($errors)) {
        $livro->titulo = $_POST['titulo'];
        $livro->id_autor = $_POST['id_autor'];

        if ($livro->create()) {
            echo "<div class='alert alert-success'>Livro criado com sucesso.</div>";
        } else {
            echo "<div class='alert alert-danger'>Não foi possível criar o livro.</div>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>{$error}</div>";
        }
    }
}

$stmt = $autor->readAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Livro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Adicionar Livro</h2>
        <form action="create.php" method="post">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="id_autor">Autor:</label>
                <select class="form-control" name="id_autor" required>
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nome']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
</body>
</html>