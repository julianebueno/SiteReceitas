<?php 

if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['id'])) {
  die("Você precisa estar logado para essa página! <br><a href=\"../pages/login.php\">Login</a>");
}

?>