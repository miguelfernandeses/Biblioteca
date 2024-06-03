<?php
include_once '../config/Database.php';
include_once '../classes/Autor.php';

$database = new Database();
$db = $database->getConnection();

$autor = new Autor($db);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 5;
$from_record_num = ($records_per_page * $page) - $records_per_page;

$stmt = $autor->read($from_record_num, $records_per_page);
$num = $stmt->rowCount();
$total_rows = $autor->count();
$total_pages = ceil($total_rows / $records_per_page);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Autores</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Autores</h2>
        <a href="create.php" class="btn btn-primary">Adicionar Autor</a>
        <?php
        if ($num > 0) {
            echo "<table class='table table-bordered'>";
            echo "<tr><th>ID</th><th>Nome</th><th>Email</th><th>Ações</th></tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$nome}</td>";
                echo "<td>{$email}</td>";
                echo "<td><a href='update.php?id={$id}' class='btn btn-warning'>Editar</a> <a href='delete.php?id={$id}' class='btn btn-danger'>Excluir</a></td>";
                echo "</tr>";
            }
            echo "</table>";

            echo "<nav aria-label='Page navigation'>";
            echo "<ul class='pagination'>";
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<li class='page-item'><a class='page-link' href='index.php?page={$i}'>{$i}</a></li>";
            }
            echo "</ul>";
            echo "</nav>";
        } else {
            echo "<div class='alert alert-info'>Nenhum autor encontrado.</div>";
        }
        ?>
    </div>
</body>
</html>