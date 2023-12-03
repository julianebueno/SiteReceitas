<?php 
include('../php/protecao2.php');

if (!isset($_SESSION)) session_start();
session_destroy();
header('Location: ../../');

?>