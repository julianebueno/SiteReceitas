<?php
include('../php/conexao.php');
include('../php/protecao2.php');

if (!isset($_SESSION)) session_start();

if (isset($_SESSION['id'])) {
  $user_id = $_SESSION['id'];
  $sql = "SELECT * FROM usuarios WHERE id = '$user_id'";
  $result = $mysqli->query($sql) or die($mysqli->error);
  if ($result->num_rows == 1) {
    $user_data = $result->fetch_assoc();
    $email = $user_data['email'];
    if ($email == 'admin@admin') {
      echo '<script>
        alert("Não é possível excluir o usuário administrador!");
        setTimeout(function(){
          window.location.href = "../pages/perfil.php";
        }, 1000);
      </script>';
    } else {
      $sql = "DELETE FROM usuarios WHERE id = '$user_id'";
      if ($mysqli->query($sql) === TRUE) {
        header('Location: logout.php');
      } else {
        $error_message = "Erro ao excluir o registro!";
      }
    }
  } else {
    $error_message = "ID do usuário não encontrado no banco de dados!";
  }
} else {
  $error_message = "ID do usuário não encontrado na sessão!";
}
