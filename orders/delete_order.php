<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../index.php");
  exit();
}
if (isset($_GET["id_bon"])) {
  $ref = $_GET['id_bon'];
  include_once("../includes/connecionDB.php");
  $query = "DELETE FROM contenir WHERE id_bon = $ref";
  $pdo->query($query);
  include_once("../includes/log.php");
  logActivity($_SESSION['user'], "Suppréssion d'un commande");
}

header("location: ./list_order.php");
exit;
