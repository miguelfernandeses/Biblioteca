# Biblioteca CRUD

Este é um projeto simples de CRUD (Create, Read, Update, Delete) para gerenciar autores e livros, desenvolvido em PHP orientado a objetos. O projeto utiliza MySQL como banco de dados e Bootstrap para estilização das páginas.

## Funcionalidades

- **Autores**: Adicionar, listar, editar e excluir autores.
- **Livros**: Adicionar, listar, editar e excluir livros.
- **Autenticação**: Sistema de login e registro de usuários.

## Requisitos

- PHP 7.0 ou superior
- MySQL
- Servidor Apache (recomendado: XAMPP ou WAMP)

## Instalação

### Passo 1: Clonar o Repositório

1. Clone este repositório para o diretório `htdocs` do XAMPP ou o diretório `www` do WAMP:

   git clone https://github.com/seu-usuario/biblioteca-crud.git


Navegue até o diretório do projeto:
cd biblioteca-crud

Passo 2: Configuração do Banco de Dados

Crie um banco de dados no MySQL chamado biblioteca.
Importe o arquivo biblioteca.sql que está localizado na pasta database do projeto. Você pode fazer isso através do phpMyAdmin ou pela linha de comando:

Usando phpMyAdmin:

Acesse o phpMyAdmin.
Selecione o banco de dados biblioteca.
Clique na aba "Importar".
Selecione o arquivo biblioteca.sql localizado na pasta database do projeto.
Clique em "Executar".
Usando a linha de comando:

mysql -u root -p biblioteca < database/biblioteca.sql

Passo 3: Configuração do Arquivo de Conexão
Verifique se o arquivo config/Database.php está configurado corretamente com as credenciais do seu banco de dados:

<?php
class Database {
    private $host = "localhost";
    private $db_name = "biblioteca";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>


Passo 4: Iniciar o Servidor

Inicie o servidor Apache e MySQL através do painel de controle do XAMPP ou WAMP.
Acesse o projeto através do navegador: http://localhost/biblioteca-crud.

Uso

Autores

Listar Autores: http://localhost/biblioteca-crud/autores/index.php

Adicionar Autor: http://localhost/biblioteca-crud/autores/create.php

Editar Autor: http://localhost/biblioteca-crud/autores/update.php?id={id}

Excluir Autor: http://localhost/biblioteca-crud/autores/delete.php?id={id}

Livros
Listar Livros: http://localhost/biblioteca-crud/livros/index.php

Adicionar Livro: http://localhost/biblioteca-crud/livros/create.php

Editar Livro: http://localhost/biblioteca-crud/livros/update.php?id={id}

Excluir Livro: http://localhost/biblioteca-crud/livros/delete.php?id={id}

Autenticação

Registro: http://localhost/biblioteca-crud/usuarios/register.php

Login: http://localhost/biblioteca-crud/usuarios/login.php

Logout: http://localhost/biblioteca-crud/usuarios/logout.php



Contribuição
Se você quiser contribuir com este projeto, sinta-se à vontade para abrir um pull request ou relatar problemas na seção de issues.
