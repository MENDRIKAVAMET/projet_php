<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

require_once("./includes/connecionDB.php");
$req = "SELECT count(*) as nombre FROM users where username = '$username'and mdp = '$password'";
$result = $pdo->query($req);
$user = $result->fetch();
if ($user['nombre'] == '1') {
  $_SESSION['user'] = $username;
  header("Location: dashboard.php");
  exit();
} else {
  header('location: index.php?result=incorrect');
  exit;
}
?>
