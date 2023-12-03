<?php
include('../php/conexao.php');
include('../php/protecao.php');

if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['confirmaSenha'])) {

  $nome = $mysqli->real_escape_string($_POST['nome']);
  $email = $mysqli->real_escape_string($_POST['email']);
  $senha = $mysqli->real_escape_string($_POST['senha']);
  $confirmaSenha = $mysqli->real_escape_string($_POST['confirmaSenha']);

  if ($senha != $confirmaSenha) {
    $error_message = "As senhas não coincidem!";
  } else {
    $options = [
      'cost' => 12,
    ];
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT, $options);

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $mysqli->query($sql) or die($mysqli->error);

    if ($result->num_rows > 0) {
      $error_message = "Email já cadastrado!";
    } else {
      $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha_hash')";
      if ($mysqli->query($sql) === TRUE) {
        header('Location: login.php');
      } else {
        $error_message = "Erro ao cadastrar!";
      }
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

        <div class="col-md-3 text-end d-flex flex-nowrap">
          <a href="./login.php" class="btn btn-outline-primary me-2">Entrar</a>
          <a href="./cadastro.php" class="btn btn-primary">Cadastrar</a>
        </div>
      </div>
    </div>
  </header>

  <main class=" main_cadastro m-auto p-2">
    <form class="form-signin w-100" action="" method="POST">

      <img class="mb-3 mx-auto w-100" src="../img/favicon.svg" alt="logo" width="36" height="28">
      <h1 class="h3 mb-3 fw-normal text-center">Cadastrar</h1>

      <div class="form-floating py-1">
        <input type="text" class="form-control" id="floatingName" placeholder="Seu nome" name="nome" required>
        <label for="floatingName">Nome</label>
      </div>
      <div class="form-floating py-1">
        <input type="email" class="form-control" id="floatingEmail" placeholder="email@provedor.com" name="email" required>
        <label for="floatingEmail">Email</label>
      </div>
      <div class="form-floating py-1">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Senha" name="senha" required>
        <label for="floatingPassword">Senha</label>
      </div>
      <div class="form-floating py-1">
        <input type="password" class="form-control" id="floatingPassword2" placeholder="Repita a Senha" name="confirmaSenha" required>
        <label for="floatingPassword2">Confirmação de Senha</label>
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