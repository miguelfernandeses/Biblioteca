<?php
// Inclui os arquivos de configuração do banco de dados e as classes Livro e Autor
include_once '../config/Database.php';
include_once '../classes/Livro.php';
include_once '../classes/Autor.php';

// Função para validar os dados do formulário
function validate($data) {
    $errors = [];

    // Verifica se o título está vazio
    if (empty($data['titulo'])) {
        $errors[] = "Título é obrigatório.";
    }

    // Verifica se o autor está vazio
    if (empty($data['id_autor'])) {
        $errors[] = "Autor é obrigatório.";
    }

    return $errors;
}

// Cria uma nova instância da classe Database e obtém a conexão
$database = new Database();
$db = $database->getConnection();

// Cria novas instâncias das classes Livro e Autor
$livro = new Livro($db);
$autor = new Autor($db);

// Obtém o ID do livro a ser editado
$livro->id = isset($_GET['id']) ? $_GET['id'] : die('ID não encontrado.');

// Lê os dados do livro
$livro->readOne();

// Verifica se o formulário foi enviado
if ($_POST) {
    // Valida os dados do formulário
    $errors = validate($_POST);

    // Se não houver erros, tenta atualizar o livro
    if (empty($errors)) {
        $livro->titulo = $_POST['titulo'];
        $livro->id_autor = $_POST['id_autor'];

        if ($livro->update()) {
            echo "<div class='alert alert-success'>Livro atualizado com sucesso.</div>";
        } else {
            echo "<div class='alert alert-danger'>Não foi possível atualizar o livro.</div>";
        }
    } else {
        // Exibe os erros de validação
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>{$error}</div>";
        }
    }
}

// Obtém todos os autores para preencher o campo de seleção
$stmt = $autor->readAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Livro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Editar Livro</h2>
        <form action="update.php?id=<?php echo $livro->id; ?>" method="post">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" name="titulo" value="<?php echo $livro->titulo; ?>" required>
            </div>
            <div class="form-group">
                <label for="id_autor">Autor:</label>
                <select class="form-control" name="id_autor" required>
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $livro->id_autor) echo 'selected'; ?>><?php echo $row['nome']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
</body>
</html>