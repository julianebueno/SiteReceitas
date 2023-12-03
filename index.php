<?php
if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- FAVICON -->
  <link rel="icon" type="image/svg+xml" href="./src/img/favicon.svg" />

  <!-- BOOTSTRAP STYLE -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <!-- CSS -->
  <link rel="stylesheet" href="./src/css/style.css">

  <!-- JS -->
  <script src="./src/js/script.js" defer></script>

  <title>Receitas</title>
</head>

<body>

  <header class="py-3 mb-3 border-bottom">
    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
      <a href="./" class="d-flex align-items-center col-lg-4 mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
        <img class="w-25" src="./src/img/favicon.svg" alt="logo">
      </a>

      <div class="d-flex align-items-center">
        <form class="w-100 me-3" role="search">
          <input type="search" class="form-control" placeholder="Procurar..." aria-label="Search">
        </form>

        <?php
        if (isset($_SESSION['id'])) {
          echo
          '
            <div class="flex-shrink-0 dropdown">
              <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSTip18a5vyLJJXYZgGE44WTFaislpkAcvQURSqLik0tsv8DuPggkyib-NrlShXqM2mO9k&usqp=CAU" alt="Foto de perfil do usuário" width="32" height="32" class="rounded-circle">
              </a>
              <ul class="dropdown-menu text-small shadow">
                <li><a class="dropdown-item" href="./src/pages/perfil.php">Perfil</a></li>
                ';
          if ($_SESSION['email'] == 'admin@admin') {
            echo '<li><a class="dropdown-item" href="./src/pages/cadastro_receita.php">Cadastrar Receita</a></li>';
          }
          echo '
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="./src/php/logout.php">Sair</a></li>
              </ul>
            </div>
          ';
        } else {
          echo '
            <div class="col-md-3 text-end d-flex flex-nowrap">
              <a href="./src/pages/login.php" class="btn btn-outline-primary me-2">Entrar</a>
              <a href="./src/pages/cadastro.php" class="btn btn-primary">Cadastrar</a>
            </div>
          ';
        }
        ?>

      </div>
    </div>
  </header>

  <main class="container">
    <div class="p-4 p-md-5 mb-4 border rounded text-body-emphasis bg-body row flex-md-row justify-content-between shadow-sm h-md-250">
      <div class="col-lg-8 px-0">
        <h1 class="display-4">Olá, Seja bem vindo ao <strong>Receitas</strong></h1>
        <p class="lead my-3">Um ambiente com várias receitas para todos os gostos e bolsos, da simplicidade à complexidade do sabor e magia da culinária.</p>
      </div>
      <div class="col-auto d-none d-lg-block">
        <img src="./src/img/panela-comida.png" alt="Foto de perfil do usuário" width="250" height="100%">
      </div>
    </div>

    <div class="row mb-2">

      <?php 
      include('./src/php/conexao.php');
      
      $sql = "SELECT * FROM receitas";
      $result = $mysqli->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { 
          echo '
          <div class="col-md-6">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
              <div class="col p-4 d-flex flex-column position-static bg-body">
                <strong class="d-inline-block mb-2 text-primary-emphasis">' . $row['tipo'] . '</strong>
                <h3 class="mb-0">' . $row['nome'] . '</h3>
                <div class="mb-1 text-body-secondary">' . $row['cadastrado_em'] . '</div>
                <p class="card-text mb-auto">' . $row['descricao'] . '</p>
                <a href="./src/pages/receita.php?id=' . $row['idReceita'] . '" class="icon-link gap-1 icon-link-hover stretched-link">Ver receita</a>
              </div>
              <div class="col-auto d-none d-lg-block">
                <img src="' . $row['imagem'] . '" alt="Foto de ' . $row['nome'] . '" width="200" height="100%">
              </div>
            </div>
          </div>
          ';
        }
      } else {
        echo 'Nenhuma receita encontrada!';
      }
      ?>
    </div>

  </main>

  <footer class="d-flex flex-wrap justify-content-center align-items-center py-3 border-top mt-auto">
    <p class="text-body-secondary">Feito por Juliane Bueno </p>
    <p class="text-body-secondary">&copy; Todos os Direitos Reservados</p>
  </footer>

  <!-- BOOTSTRAP SCRIPT -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>