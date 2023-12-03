<?php 

if (!isset($_SESSION)) session_start();

if (isset($_SESSION['id'])) {
  die("Você já está logado! <br><a href=\"../../\">Pagina Inicial</a>");
}

?>