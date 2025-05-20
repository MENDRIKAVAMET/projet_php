<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../index.php");
  exit();
}
if(isset($_GET["ref_scooter"]))
{
  $ref = $_GET['ref_scooter'];
  include_once("../includes/connecionDB.php");
  $query = "DELETE FROM scooter where ref_scooter ='$ref' ";
  $pdo->query($query);
  include_once("../includes/log.php");
  logActivity($_SESSION['user'], "Suppréssion d'un scooter");
}

header("location: ./list_scooter.php");
exit;
?>
