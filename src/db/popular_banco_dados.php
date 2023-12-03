<?php

if (!isset($_SESSION)) session_start();
session_destroy();

$username = "root";
$password = "";
$host = "localhost";
$database = "SiteReceitas";

$mysqli = new mysqli($host, $username, $password);

if ($mysqli->error) {
  die("Falha na conexão com o banco de dados. " . $mysqli->error);
}

$query_db = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'";
$result = $mysqli->query($query_db);

if ($result->num_rows > 0) {
  $drop_db_query = "DROP DATABASE $database";
  if ($mysqli->query($drop_db_query) === TRUE) {
    echo "Banco de dados anterior excluído com sucesso!<br>";
    $create_db_query = "CREATE DATABASE $database";
    if ($mysqli->query($create_db_query) === TRUE) {
      echo "Novo banco de dados criado com sucesso!";

      $mysqli->select_db($database);

      // ===================================================================== TABELA USUARIOS
      $sql_usuarios = "CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        senha VARCHAR(255) NOT NULL,
        favoritas TEXT
      )";

      if ($mysqli->query($sql_usuarios) === TRUE) {
        echo "Tabela 'usuarios' criada com sucesso!<br>";
      } else {
        echo "Erro ao criar a tabela 'usuarios': " . $mysqli->error . "<br>";
      }
      
      $options = [
        'cost' => 12, // Cost determina a força do hash (quanto maior, mais seguro mas também mais lento)
      ];
      $senha_hash1 = password_hash('admin', PASSWORD_DEFAULT, $options);
      $senha_hash2 = password_hash(123456, PASSWORD_DEFAULT, $options);

      $receitas_favoritas = [1, 3, 5];
      $ids_string = implode(',', $receitas_favoritas);

      $sql_insert_usuarios = "INSERT INTO usuarios (nome, email, senha, favoritas) VALUES
      ('Admin', 'admin@admin', '$senha_hash1', '$ids_string'),
      ('Maria', 'maria@maria', '$senha_hash2', '$ids_string')";

      if ($mysqli->query($sql_insert_usuarios) === TRUE) {
        echo "Dados inseridos na tabela 'usuarios' com sucesso!<br>";
      } else {
        echo "Erro ao inserir dados na tabela 'usuarios': " . $mysqli->error . "<br>";
      }

      // ===================================================================== TABELA RECEITAS
      $sql_receitas = "CREATE TABLE IF NOT EXISTS receitas (
        idReceita INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(50) NOT NULL,
        descricao VARCHAR(200) NOT NULL,
        tipo VARCHAR(50) NOT NULL,
        cadastrado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        imagem VARCHAR(200) NOT NULL
      )";

      if ($mysqli->query($sql_receitas) === TRUE) {
        echo "Tabela 'receitas' criada com sucesso!<br>";
      } else {
        echo "Erro ao criar a tabela 'receitas': " . $mysqli->error . "<br>";
      }

      $sql_insert_receitas = "INSERT INTO receitas (nome, descricao, tipo, imagem) VALUES
      ('Brigadeiro', 'O melhor doce do Brasil!', 'Sobremesa', 'https://anamariabraga.globo.com/wp-content/uploads/2016/11/brigadeiro-1024x576.jpg'),
      ('Arroz', 'Bem soltinho e saboroso!', 'Básicos', 'https://static.itdg.com.br/images/360-240/21fd76be3b29c3290859eda5220e0e32/323683-original.jpg'),
      ('Escondidinho', 'Um escondidinho com muito sabor.', 'Básicos', 'https://bakeandcakegourmet.com.br/uploads/site/receitas/escondidinho-de-carne-moida-x3hxxplr.jpg'),
      ('Churrasco', 'Para aproveitar o fim de semana!', 'Carnes', 'https://supermercadosrondon.com.br/guiadecarnes/images/postagens/as_7_melhores_carnes_para_churrasco_21-05-2019.jpg')";

      if ($mysqli->query($sql_insert_receitas) === TRUE) {
        echo "Dados inseridos na tabela 'receitas' com sucesso!<br>";
      } else {
        echo "Erro ao inserir dados na tabela 'receitas': " . $mysqli->error . "<br>";
      }

      echo "Script para popular banco de dados finalizado com Sucesso!<br>";
      echo "Você será redirecionado para a página inicial em 5 segundos...<br>";
      header("refresh:5;url=../../");
    } else {
      echo "Erro ao criar o novo banco de dados: " . $mysqli->error;
    }
  } else {
    echo "Erro ao excluir o banco de dados anterior: " . $mysqli->error . "<br>";
  }
}

$mysqli->close();
