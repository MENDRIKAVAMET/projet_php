<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../index.php");
  exit();
}
if (isset($_GET['id_client'])) {
  $id = $_GET['id_client'];

  include_once("../includes/connecionDB.php");

  $query = "DELETE FROM client where id_client = $id";
  $pdo->query($query);
  include_once("../includes/log.php");
  logActivity($_SESSION['user'], "Suppréssion d'un client");
}

header("location: ./list_client.php");
exit;
