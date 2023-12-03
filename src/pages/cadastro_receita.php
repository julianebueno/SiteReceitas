<?php
include('../php/conexao.php');
include('../php/protecao3.php');

if (isset($_POST['tipo']) && isset($_POST['nome']) && isset($_POST['descricao']) && isset($_POST['imagem'])) {

  $tipo = $mysqli->real_escape_string($_POST['tipo']);
  $nome = $mysqli->real_escape_string($_POST['nome']);
  $descricao = $mysqli->real_escape_string($_POST['descricao']);
  $imagem = $mysqli->real_escape_string($_POST['imagem']);
  $date = date("Y-m-d");

  $sql = "SELECT * FROM receitas WHERE nome = '$nome'";
  $result = $mysqli->query($sql) or die($mysqli->error);

  if ($result->num_rows > 0) {
    $error_message = "Nome de receita já cadastrado!";
  } else {
    $sql = "INSERT INTO receitas (tipo, nome, descricao, imagem, cadastrado_em) VALUES ('$tipo', '$nome', '$descricao', '$imagem', '$date')";
    if ($mysqli->query($sql) === TRUE) {
      header('Location: ../../');
    } else {
      $error_message = "Erro ao cadastrar!";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- FAVICON -->
  <link rel="icon" type="image/svg+xml" href="../img/favicon.svg" />

  <!-- BOOTSTRAP STYLE -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <!-- CSS -->
  <link rel="stylesheet" href="../css/style.css">

  <!-- JS -->
  <script src="../js/script.js" defer></script>

  <title>Receitas</title>
</head>

<body>

  <header class="py-3 mb-3 border-bottom">
    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
      <a href="../../" class="d-flex align-items-center col-lg-4 mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
        <img class="w-25" src="../img/favicon.svg" alt="logo">
      </a>

      <div class="d-flex align-items-center">
        <form class="w-100 me-3" role="search">
          <input type="search" class="form-control" placeholder="Procurar..." aria-label="Search">
        </form>

        <div class="flex-shrink-0 dropdown">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSTip18a5vyLJJXYZgGE44WTFaislpkAcvQURSqLik0tsv8DuPggkyib-NrlShXqM2mO9k&usqp=CAU" alt="Foto de perfil do usuário" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small shadow">
            <li><a class="dropdown-item" href="./perfil.php">Perfil</a></li>
            <?php if ($_SESSION['email'] == 'admin@admin') {
              echo '<li><a class="dropdown-item" href="../pages/cadastro.php">Cadastrar Receita</a></li>';
            } ?>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="../php/logout.php">Sair</a></li>
          </ul>
        </div>

      </div>
    </div>
  </header>

  <main class=" main_cadastro m-auto p-2">
    <form class="form-signin w-100" action="" method="POST">

      <img class="mb-3 mx-auto w-100" src="../img/favicon.svg" alt="logo" width="36" height="28">
      <h1 class="h3 mb-3 fw-normal text-center">Cadastrar Receita</h1>

      <div class="form-floating py-1">
        <input type="text" class="form-control" id="tipo" placeholder="Tipo de receita" name="tipo" required>
        <label for="tipo">Tipo</label>
      </div>
      <div class="form-floating py-1">
        <input type="text" class="form-control" id="nome" placeholder="Nome da receita" name="nome" required>
        <label for="nome">Nome</label>
      </div>
      <div class="form-floating py-1">
        <input type="text" class="form-control" id="descricao" placeholder="Descrição da receita" name="descricao" required>
        <label for="descricao">Descrição</label>
      </div>
      <div class="form-floating py-1">
        <input type="text" class="form-control" id="imagem" placeholder="Imagem da receita" name="imagem" required>
        <label for="imagem">Imagem</label>
      </div>

      <?php
      if (isset($error_message)) {
        echo "<p style='color: #FF0000;'>$error_message</p>";
      }
      ?>

      <button class="btn btn-primary w-100 py-2 mt-3" type="submit">Cadastrar</button>
    </form>
  </main>

  <footer class="d-flex flex-wrap justify-content-center align-items-center py-3 border-top mt-auto">
    <p class="text-body-secondary">Feito por Juliane Bueno </p>
    <p class="text-body-secondary">&copy; Todos os Direitos Reservados</p>
  </footer>

  <!-- BOOTSTRAP SCRIPT -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>