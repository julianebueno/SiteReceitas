<?php 

if (!isset($_SESSION)) session_start();

if ($_SESSION['email'] !== 'admin@admin') {
  die("Você precisa estar logado como administrador para esta página! <br><a href=\"../../\">Inicial</a>");
}

?>