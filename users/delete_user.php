<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../index.php");
  exit();
}
if (isset($_GET['username'])) {
  $id = $_GET['username'];

  include_once("../includes/connecionDB.php");

  $query = "DELETE FROM users where username = '$id'";
  $pdo->query($query);
  include_once("../includes/log.php");
  logActivity($_SESSION['user'], "Suppréssion d'un utilisateur");
}

header("location: ./list_client.php");
exit;
