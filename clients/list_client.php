<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../index.php");
  exit();
}
include('../includes/connecionDB.php');

$order = '';
if ($_SERVER['REQUEST_METHOD'] === "GET") {
  if (isset($_GET['id']) && isset($_GET['DESC']) && !isset($_GET['prenom']) && !isset($_GET['nom'])) {
    $order = ' ORDER BY id_client DESC';
  } else if (isset($_GET['id']) && !isset($_GET['DESC']) && !isset($_GET['prenom']) && !isset($_GET['nom'])) {
    $order = ' ORDER BY id_client';
  } else if (isset($_GET['id']) && isset($_GET['DESC']) && !isset($_GET['prenom']) && !isset($_GET['nom'])) {
    $order = ' ORDER BY id_client DESC';
  } else if (!isset($_GET['id']) && isset($_GET['DESC']) && isset($_GET['prenom']) && !isset($_GET['nom'])) {
    $order = ' ORDER BY prenom DESC';
  } else if (!isset($_GET['id']) && !isset($_GET['DESC']) && isset($_GET['prenom']) && !isset($_GET['nom'])) {
    $order = ' ORDER BY prenom';
  } else if (!isset($_GET['id']) && isset($_GET['DESC']) && !isset($_GET['prenom']) && isset($_GET['nom'])) {
    $order = ' ORDER BY nom DESC';
  } else if (!isset($_GET['id']) && !isset($_GET['DESC']) && !isset($_GET['prenom']) && isset($_GET['nom'])) {
    $order = ' ORDER BY nom';
  }
}

$result = $pdo->query("SELECT * FROM client" . $order);

?>



<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Scooters - GetScooter</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?> ">
</head>

<body>
  <?php require_once("../includes/menu_lateral_nav.php"); ?>

  <div class="container">
    <div class="controls">
      <form action="list_client.php" method="GET">
        <div class="sort-options">
          <div class="sort-option">
            <input type="checkbox" name="id" value="1" <?= isset($_GET['id']) ? 'checked' : '' ?>>
            <label for="id">ID</label>
          </div>
          <div class="sort-option">
            <input type="checkbox" name="nom" value="1" <?= isset($_GET['nom']) ? 'checked' : '' ?>>
            <label for="nom">Nom</label>
          </div>
          <div class="sort-option">
            <input type="checkbox" name="prenom" value="1" <?= isset($_GET['prenom']) ? 'checked' : '' ?>>
            <label for="prenom">Prenom</label>
          </div>
          <div class="sort-option">
            <input type="checkbox" name="DESC" value="1" <?= (isset($_GET['DESC']) && $_GET['DESC'] === "1") ? 'checked' : '' ?>>
            <label for="DESC">Décroissant</label>
          </div>
          <button type="submit" style="color: white;" class="add-btn">Valider</button>
        </div>
      </form>
      <button class="add-btn" id="addScooter">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="5" x2="12" y2="19"></line>
          <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        <a href="add_client.php" style="text-decoration: none">Ajouter un client</a>
      </button>
    </div>
    <table>
      <thead>
        <tr>
          <th>Id_client</th>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Phone</th>
          <th>CIN</th>
          <th>Pays</th>
          <th>Ville</th>
          <th>Date de naissance</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($client = $result->fetch()) {
        ?>
          <tr>
            <td> <?php echo $client["id_client"]; ?></td>
            <td> <?php echo $client["nom"]; ?></td>
            <td> <?php echo $client["prenom"]; ?></td>
            <td> <?php echo $client["phone"]; ?></td>
            <td> <?php echo $client["cin"]; ?></td>
            <td> <?php echo $client["pays"]; ?></td>
            <td> <?php echo $client["ville"]; ?></td>
            <td> <?php echo $client["date_naiss"]; ?></td>
            <td>
              <a href="edit_client.php?id_client=<?php echo $client["id_client"] ?>">✏️</a>
              <a href="delete_client.php?id_client=<?php echo $client["id_client"] ?>" onclick="return confirm('Supprimer ?')">🗑️</a>
            </td>
          </tr>

        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
</body>

</html>