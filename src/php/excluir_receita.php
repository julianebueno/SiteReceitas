<?php
include('../php/conexao.php');
include('../php/protecao2.php');

if (!isset($_SESSION)) session_start();

if (isset($_SESSION['email']) == 'admin@admin') {
  $id_recebido = $_GET['id'];
  $sql = "SELECT * FROM receitas WHERE idReceita = '$id_recebido'";
  $result = $mysqli->query($sql) or die($mysqli->error);
  if ($result->num_rows == 1) {
    $sql = "DELETE FROM receitas WHERE idReceita = '$id_recebido'";
    if ($mysqli->query($sql) === TRUE) {
      header('Location: ../../');
    } else {
      $error_message = "Erro ao excluir o registro!";
    }
  }
} else {
  header('Location: ../../');
}
