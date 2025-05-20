<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../index.php");
  exit();
}
include('../includes/connecionDB.php');
$order = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['ref']) && !isset($_GET['marque']) && !isset($_GET['modele']) && !isset($_GET['prix']) && !isset($_GET['stock']) && !isset($_GET['DESC'])) {
    $order = ' ORDER BY ref_scooter';
  } else if (isset($_GET['ref']) && !isset($_GET['marque']) && !isset($_GET['modele']) && !isset($_GET['prix']) && !isset($_GET['stock']) && isset($_GET['DESC'])) {
    $order = ' ORDER BY ref_scooter DESC';
  } else if (!isset($_GET['ref']) && isset($_GET['marque']) && !isset($_GET['modele']) && !isset($_GET['prix']) && !isset($_GET['stock']) && isset($_GET['DESC'])) {
    $order = ' ORDER BY marque DESC';
  } else if (isset($_GET['ref']) && isset($_GET['marque']) && !isset($_GET['modele']) && !isset($_GET['prix']) && !isset($_GET['stock']) && !isset($_GET['DESC'])) {
    $order = ' ORDER BY marque';
  } else if (!isset($_GET['ref']) && !isset($_GET['marque']) && isset($_GET['modele']) && !isset($_GET['prix']) && !isset($_GET['stock']) && isset($_GET['DESC'])) {
    $order = ' ORDER BY modele DESC';
  } else if (!isset($_GET['ref']) && !isset($_GET['marque']) && isset($_GET['modele']) && !isset($_GET['prix']) && !isset($_GET['stock']) && !isset($_GET['DESC'])) {
    $order = ' ORDER BY modele';
  } else if (!isset($_GET['ref']) && !isset($_GET['marque']) && !isset($_GET['modele']) && isset($_GET['prix']) && !isset($_GET['stock']) && isset($_GET['DESC'])) {
    $order = ' ORDER BY prix DESC';
  } else if (!isset($_GET['ref']) && !isset($_GET['marque']) && !isset($_GET['modele']) && isset($_GET['prix']) && !isset($_GET['stock']) && !isset($_GET['DESC'])) {
    $order = ' ORDER BY prix';
  } else if (!isset($_GET['ref']) && !isset($_GET['marque']) && !isset($_GET['modele']) && !isset($_GET['prix']) && isset($_GET['stock']) && isset($_GET['DESC'])) {
    $order = ' ORDER BY quantite_stock DESC';
  } else if (!isset($_GET['ref']) && !isset($_GET['marque']) && !isset($_GET['modele']) && !isset($_GET['prix']) && isset($_GET['stock']) && !isset($_GET['DESC'])) {
    $order = ' ORDER BY quantite_stock';
  }
}

$result = $pdo->query("SELECT * FROM scooter" . $order);
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
      <form action="list_scooter.php" method="GET">
        <div class="sort-options">
          <div class="sort-option">
            <input type="checkbox" name="ref" value="1" <?= isset($_GET['ref']) ? 'checked' : '' ?>>
            <label for="sort-ref">Référence</label>
          </div>
          <div class="sort-option">
            <input type="checkbox" name="marque" value="1" <?= isset($_GET['marque']) ? 'checked' : '' ?>>
            <label for="sort-marque">Marque</label>
          </div>
          <div class="sort-option">
            <input type="checkbox" name="modele" value="1" <?= isset($_GET['modele']) ? 'checked' : '' ?>>
            <label for="sort-modele">Modèle</label>
          </div>
          <div class="sort-option">
            <input type="checkbox" name="prix" value="1" <?= isset($_GET['prix']) ? 'checked' : '' ?>>
            <label for="sort-prix">Prix</label>
          </div>
          <div class="sort-option">
            <input type="checkbox" name="stock" value="1" <?= isset($_GET['stock']) ? 'checked' : '' ?>>
            <label for="sort-stock">Stock</label>
          </div>
          <div class="sort-option">
            <input type="checkbox" name="DESC" value="1" <?= (isset($_GET['DESC']) && $_GET['DESC'] === "1") ? 'checked' : '' ?>>
            <label for="sort-stock">Décroissante</label>
          </div>
          <button type="submit" style="color:white;" class="add-btn">Valider</button>
        </div>
      </form>
      <button class="add-btn" id="addScooter">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="5" x2="12" y2="19"></line>
          <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        <a href="add_scooter.php" style="text-decoration: none">Ajouter un scooter</a>
      </button>
    </div>

    <table>
      <thead>
        <tr>
          <th>référence</th>
          <th>marque</th>
          <th>Modèle</th>
          <th>Prix</th>
          <th>Quantite en stock</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($scooter = $result->fetch()) {
        ?>
          <tr>
            <td> <?php echo $scooter["ref_scooter"]; ?></td>
            <td> <?php echo $scooter["marque"]; ?></td>
            <td> <?php echo $scooter["modele"]; ?></td>
            <td> <?php echo $scooter["prix"]; ?></td>
            <td> <?php echo $scooter["quantite_stock"]; ?></td>
            <td class="actions">
              <a href="edit_scooter.php?ref_scooter=<?php echo $scooter["ref_scooter"] ?>">✏️</a>
              <a href="delete_scooter.php?ref_scooter=<?php echo $scooter["ref_scooter"] ?>" onclick="return confirm('Supprimer ?')">🗑️</a>
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