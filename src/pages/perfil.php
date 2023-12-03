<?php
include('../php/conexao.php');
include('../php/protecao2.php');

if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['confirmaSenha'])) {

  $nome = $mysqli->real_escape_string($_POST['nome']);
  $email = $mysqli->real_escape_string($_POST['email']);
  $senha = $mysqli->real_escape_string($_POST['senha']);
  $confirmaSenha = $mysqli->real_escape_string($_POST['confirmaSenha']);

  if ($senha != $confirmaSenha) {
    $error_message = "As senhas não coincidem!";
  } else {

    $user_id = $_SESSION['id'];
    $sql = "SELECT * FROM usuarios WHERE id = '$user_id'";
    $result = $mysqli->query($sql) or die($mysqli->error);

    if ($result->num_rows == 1) {
      $user_data = $result->fetch_assoc();
      $email = $user_data['email'];
      if ($email == 'admin@admin') {
        echo '<script>
          alert("Não é possível editar o usuário administrador!");
          setTimeout(function(){
            window.location.href = "../pages/perfil.php";
          }, 1000);
        </script>';
      } else {
        $sql = "UPDATE usuarios SET nome = '$nome', email = '$email', senha = '$senha' WHERE id = '$user_id'";

        if ($mysqli->query($sql) === TRUE) {
          $usuario = $result->fetch_assoc();
          $_SESSION['nome'] = $nome;
          $_SESSION['email'] = $email;
          header('Location: perfil.php');
        } else {
          $error_message = "Erro ao atualizar!";
        }
      }
    } else {
      $error_message = "Erro na procura do usuário!";
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

        <div class="flex-shrink-0 dropdown">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSTip18a5vyLJJXYZgGE44WTFaislpkAcvQURSqLik0tsv8DuPggkyib-NrlShXqM2mO9k&usqp=CAU" alt="Foto de perfil do usuário" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small shadow">
            <li><a class="dropdown-item" href="./perfil.php">Perfil</a></li>
            <?php if ($_SESSION['email'] == 'admin@admin') {
              echo '<li><a class="dropdown-item" href="../pages/cadastro_receita.php">Cadastrar Receita</a></li>';
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

  <main class="m-auto p-2">
    <div class="container align-items-center">
      <div class="row align-items-center m-4">
        <div class="col-12 col-md-6">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSTip18a5vyLJJXYZgGE44WTFaislpkAcvQURSqLik0tsv8DuPggkyib-NrlShXqM2mO9k&usqp=CAU" alt="Foto de perfil do usuário" class="rounded-circle w-100">
        </div>
        <div class="col-12 col-md-6">
          <h2>Olá, <?php echo $_SESSION['nome'] ?></h2>
          <p>Email: <?php echo $_SESSION['email'] ?></p>
        </div>
      </div>

      <div class="d-flex justify-content-around align-items-center">
        <button class="btn btn-secondary p-2" id="openModalBtn">Editar Dados</button>
        <button class="btn btn-danger p-2" id="openModalBtn2">Excluir Conta</button>
      </div>
    <!-- =========================================================================== FAVORITOS -->

      <div class="d-flex flex-column justify-content-around align-items-center mt-5 mb-4">
        <?php 
        include('../php/conexao.php');
        
        $sql = "SELECT favoritas FROM usuarios WHERE id = " . $_SESSION['id'];
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $ids_string = $row['favoritas'];
          $lista_favoritos = explode(',', $ids_string);

          echo '
          <h2>Suas receitas favoritas: </h2><br>
          ';

          foreach ($lista_favoritos as $favorito) {
            $sql = "SELECT * FROM receitas WHERE idReceita = '$favorito'";
            $result = $mysqli->query($sql) or die($mysqli->error);

            if ($result->num_rows == 1) {
              $receita = $result->fetch_assoc();
              echo '
              <div class="w-100">
                <div class="d-flex flex-row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                  <div class="col p-4 d-flex flex-column position-static bg-body">
                    <strong class="d-inline-block mb-2 text-primary-emphasis">' . $receita['tipo'] . '</strong>
                    <h3 class="mb-0">' . $receita['nome'] . '</h3>
                    <div class="mb-1 text-body-secondary">' . $receita['cadastrado_em'] . '</div>
                    <p class="card-text mb-auto">' . $receita['descricao'] . '</p>
                    <a href="../pages/receita.php?id=' . $receita['idReceita'] . '" class="icon-link gap-1 icon-link-hover stretched-link">Ver receita</a>
                  </div>
                  <div class="col-auto d-none d-lg-block">
                    <img src="' . $receita['imagem'] . '" alt="Foto de ' . $receita['nome'] . '" width="200" height="100%">
                  </div>
                </div>
              </div>
              ';
            }
            
          }
        } else {
          echo 'Nenhuma receita favorita encontrada!';
        }
        ?>
      </div>
    </div>

    <!-- ========================================================================================================= -->

    <div id="myModal" class="modal">

      <div class="modal-content">
        <span class="close close2">&times;</span>
        <div class="d-flex flex-column align-items-center" id="modalContent">
          <h2>Editar Dados</h2>

          <form class="form-signin w-100" action="" method="POST">
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
          <h2>Excluir Conta</h2>
          <p>Tem certeza que deseja excluir sua conta?</p>
          <p class="error">Essa ação não pode ser desfeita.</p>
          <div class="d-flex justify-content-around w-100">
            <button class="btn btn-secondary p-2 close">Cancelar</button>
            <a href="../php/excluir_usuario.php" class="btn btn-danger p-2">Excluir</a>
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