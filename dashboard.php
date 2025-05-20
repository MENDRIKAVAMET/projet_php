<?php
session_start();
include("./includes/menu_lateral_nav.php");
include_once("./includes/connecionDB.php");
$req1 = "SELECT count(*) as nombre FROM scooter";
$result1 = $pdo->query($req1);
$req2 = "SELECT count(*) as nombre FROM client";
$result2 = $pdo->query($req2);
$req3 = "SELECT count(*) as nombre FROM users";
$result3 = $pdo->query($req3);

$req4 = "SELECT action FROM log ORDER BY ID DESC LIMIT 1";
$action1 = $pdo->query($req4);
$req5 = "SELECT date_log FROM log ORDER BY ID DESC LIMIT 1";
$time1 = $pdo->query($req5);
$req6 = "SELECT action FROM log ORDER BY  ID DESC LIMIT 1, 1";
$action2 = $pdo->query($req6);
$req7 = "SELECT  date_log FROM log ORDER By ID DESC LIMIT 1,1";
$time2 = $pdo->query($req7);
$req8 = "SELECT action FROM log ORDER BY ID DESC LIMIT 2,1";
$action3 = $pdo->query($req8);
$req9 = "SELECT date_log FROM log ORDER BY ID DESC LIMIT 2,1";
$time3 = $pdo->query($req9);

if (!isset($_SESSION['user'])) {
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tableau de bord - GetScooter</title>
  <link rel="stylesheet" href="assets/css/style.css?v='<?php echo time(); ?>'">
</head>
<body>
  <div class="dashboard">
    <header>
      <h1 class="welcome">Bienvenue sur GetScooter, <?= $_SESSION['user'] ?></h1>
      
    </header>
    <div class="stats-container">
        <div class="stat-card">
            <h3>Scooters</h3>
            <div class="value" id="scooters-count"><?php $scooter = $result1->fetch(); echo $scooter['nombre']; ?></div>
        </div>
        
        <div class="stat-card">
            <h3>Clients</h3>
            <div class="value" id="clients-count"><?php $client = $result2->fetch(); echo $client['nombre']; ?></div>
        </div>
        
        <div class="stat-card">
            <h3>Utilisateurs</h3>
            <div class="value" id="users-count"><?php $user = $result3->fetch(); echo $user['nombre']; ?></div>
        </div>
    </div>


    <div class="activities">
        <h2>Dernières activités</h2>
        <div class="activity-list">
            <div class="activity-item">
                <span class="activity-description"><?php $result = $action1->fetch(); echo $result['action']; ?></span>
                <span class="activity-time"> <?php $result2 = $time1->fetch(); echo $result2['date_log']; ?></span>
            </div>
            <div class="activity-item">
                <span class="activity-description"><?php $result = $action2->fetch(); echo $result['action']; ?></span>
                <span class="activity-time"><?php $result = $time2->fetch(); echo $result['date_log']; ?></span>
            </div>
            <div class="activity-item">
                <span class="activity-description"><?php $result = $action3->fetch(); echo $result['action']; ?></span>
                <span class="activity-time"><?php $result = $time3->fetch(); echo $result['date_log']; ?></span>
            </div>
        </div>
    </div>
  </div>
  <footer>
    <p>Contact : Menzo | 📍 Andrainjato Fianarantsoa | ☎️ 0332547809 | 📧 mendrikavamet@gmail.com</p>
  </footer>
</body>
</html>
