<?php
// Inclui os arquivos de configuração do banco de dados e a classe Autor
include_once '../config/Database.php';
include_once '../classes/Autor.php';

// Função para validar os dados do formulário
function validate($data) {
    $errors = [];

    // Verifica se o nome está vazio
    if (empty($data['nome'])) {
        $errors[] = "Nome é obrigatório.";
    }

    // Verifica se o email está vazio ou inválido
    if (empty($data['email'])) {
        $errors[] = "Email é obrigatório.";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email inválido.";
    }

    return $errors;
}

// Cria uma nova instância da classe Database e obtém a conexão
$database = new Database();
$db = $database->getConnection();

// Cria uma nova instância da classe Autor
$autor = new Autor($db);

// Obtém o ID do autor a ser editado
$autor->id = isset($_GET['id']) ? $_GET['id'] : die('ID não encontrado.');

// Lê os dados do autor
$autor->readOne();

// Verifica se o formulário foi enviado
if ($_POST) {
    // Valida os dados do formulário
    $errors = validate($_POST);

    // Se não houver erros, tenta atualizar o autor
    if (empty($errors)) {
        $autor->nome = $_POST['nome'];
        $autor->email = $_POST['email'];

        if ($autor->update()) {
            echo "<div class='alert alert-success'>Autor atualizado com sucesso.</div>";
        } else {
            echo "<div class='alert alert-danger'>Não foi possível atualizar o autor.</div>";
        }
    } else {
        // Exibe os erros de validação
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>{$error}</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Autor</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Editar Autor</h2>
        <form action="update.php?id=<?php echo $autor->id; ?>" method="post">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" value="<?php echo $autor->nome; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo $autor->email; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
</body>
</html>