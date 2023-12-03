<?php

$username = "root";
$password = "";
$database = "SiteReceitas";
$host = "localhost";

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->error) {
  die("Falha na conexão com o banco de dados. " . $mysqli->error);
}
