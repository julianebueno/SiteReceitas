<?php
include('../php/conexao.php');
if (!isset($_SESSION)) session_start();

if (isset($_GET['id'])) {
  $id_recebido = $_GET['id'];
  $sql = "SELECT * FROM receitas WHERE idReceita = '$id_recebido'";
  $result = $mysqli->query($sql) or die($mysqli->error);
  if ($result->num_rows == 1) {
    $receita = $result->fetch_assoc();
    $nome = $receita['nome'];
    $tipo = $receita['tipo'];
    $descricao = $receita['descricao'];
    $imagem = $receita['imagem'];
    $cadastrado_em = $receita['cadastrado_em'];
  } else {
    $error_message = "ID da receita não encontrado no banco de dados!";
  }
} else {
  header('Location: ../../');
}

if (isset($_POST['nome']) && isset($_POST['tipo']) && isset($_POST['descricao']) && isset($_POST['imagem'])) {

  $nome_novo = $mysqli->real_escape_string($_POST['nome']);
  $tipo_novo = $mysqli->real_escape_string($_POST['tipo']);
  $descricao_novo = $mysqli->real_escape_string($_POST['descricao']);
  $imagem_novo = $mysqli->real_escape_string($_POST['imagem']);

  $sql = "SELECT * FROM receitas WHERE nome = '$nome_novo'";
  $result = $mysqli->query($sql) or die($mysqli->error);

  if ($result->num_rows == 0) {

    $sql = "SELECT * FROM receitas WHERE idReceita = '$id_recebido'";
    $result = $mysqli->query($sql) or die($mysqli->error);

    $receita_data = $result->fetch_assoc();
    $sql = "UPDATE receitas SET nome = '$nome_novo', tipo = '$tipo_novo', descricao = '$descricao_novo', imagem = '$imagem_novo' WHERE idReceita = '$id_recebido'";

    if ($mysqli->query($sql) === TRUE) {
      header('Location: ../../');
    } else {
      $error_message = "Erro ao atualizar!";
    }
  } else {
    $error_message = "Nome de receita já em uso!";
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

        <?php
        if (isset($_SESSION['id'])) {
          echo
          '
            <div class="flex-shrink-0 dropdown">
              <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSTip18a5vyLJJXYZgGE44WTFaislpkAcvQURSqLik0tsv8DuPggkyib-NrlShXqM2mO9k&usqp=CAU" alt="Foto de perfil do usuário" width="32" height="32" class="rounded-circle">
              </a>
              <ul class="dropdown-menu text-small shadow">
                <li><a class="dropdown-item" href="./perfil.php">Perfil</a></li>
                ';
          if ($_SESSION['email'] == 'admin@admin') {
            echo '<li><a class="dropdown-item" href="./cadastro_receita.php">Cadastrar Receita</a></li>';
          }
          echo '
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="../php/logout.php">Sair</a></li>
              </ul>
            </div>
          ';
        } else {
          echo '
          <div class="col-md-3 text-end d-flex flex-nowrap">
            <a href="./login.php" class="btn btn-outline-primary me-2">Entrar</a>
            <a href="./cadastro.php" class="btn btn-primary">Cadastrar</a>
          </div>
          ';
        }
        ?>

      </div>
    </div>
  </header>

  <main class="m-auto p-2">
    <div class="container align-items-center">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <?php echo '
        <div class="col p-4 d-flex flex-column position-static bg-body">
          <strong class="d-inline-block mb-2 text-primary-emphasis">' . $tipo . '</strong>
          <h3 class="mb-0">' . $nome . '</h3>
          <div class="mb-1 text-body-secondary">' . $cadastrado_em . '</div>
          <p class="card-text mb-auto">' . $descricao . '</p>
        </div>
        <div class="col-auto d-none d-lg-block">
          <img src="' . $imagem . '" alt="Foto de ' . $nome . '" width="200" height="100%">
        </div>
        ' ?>
      </div>

      <?php
      if (isset($error_message)) {
        echo "<p style='color: #FF0000;'>$error_message</p>";
      }
      ?>
      <?php
      if (isset($_SESSION['email'])) {
        if ($_SESSION['email'] == 'admin@admin') {
          echo '
            <p class="text-body-secondary bg-warning text-center">Funcões de administrador</p>
            <div class="d-flex justify-content-around align-items-center">
              <button class="btn btn-secondary p-2" id="openModalBtn">Editar</button>
              <button class="btn btn-danger p-2" id="openModalBtn2">Excluir</button>
            </div>
          ';
        }
      }
      ?>

    </div>

    <!-- ========================================================================================================= -->

    <div id="myModal" class="modal">

      <div class="modal-content">
        <span class="close close2">&times;</span>
        <div class="d-flex flex-column align-items-center" id="modalContent">
          <h2>Editar Receita</h2>

          <form class="form-signin w-100" action="" method="POST">
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

            <div class="d-flex justify-content-around w-100 mt-3">
              <button class="btn btn-secondary p-2 close">Cancelar</button>
              <button class="btn btn-primary" type="submit">Salvar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- ========================================================================================================= -->

    <div id="myModal2" class="modal modalExcluir">

      <div class="modal-content">
        <span class="close close2">&times;</span>
        <div class="d-flex flex-column align-items-center" id="modalContent">
          <h2>Excluir Receita</h2>
          <p>Tem certeza que deseja excluir?</p>
          <p class="error">Essa ação não pode ser desfeita!</p>
          <div class="d-flex justify-content-around w-100">
            <button class="btn btn-secondary p-2 close">Cancelar</button>
            <?php echo '
              <a href="../php/excluir_receita.php?id=' . $id_recebido . '" class="btn btn-danger p-2">Excluir</a>
            ' ?>
          </div>
        </div>
      </div>
    </div>

    <!-- ========================================================================================================= -->

  </main>

  <footer class="d-flex flex-wrap justify-content-center align-items-center py-3 border-top mt-auto">
    <p class="text-body-secondary">Feito por Juliane Bueno </p>
    <p class="text-body-secondary">&copy; Todos os Direitos Reservados</p>
  </footer>

  <!-- BOOTSTRAP SCRIPT -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <script>
    $(document).ready(function() {

      $("#openModalBtn").click(function() {
        $("#myModal").css("display", "block");
      });
      $("#openModalBtn2").click(function() {
        $("#myModal2").css("display", "block");
      });


      $(".close").click(function() {
        $("#myModal").css("display", "none");
      });
      $(".close").click(function() {
        $("#myModal2").css("display", "none");
      });


      $(window).click(function(event) {
        if (event.target == document.getElementById("myModal")) {
          $("#myModal").css("display", "none");
        }
      });
      $(window).click(function(event) {
        if (event.target == document.getElementById("myModal2")) {
          $("#myModal2").css("display", "none");
        }
      });
    });
  </script>

</body>

</html>