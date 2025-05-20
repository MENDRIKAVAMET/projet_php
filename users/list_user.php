<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../index.php");
  exit();
}
include('../includes/connecionDB.php');

$order = '';
if($_SERVER['REQUEST_METHOD'] === "GET")
{
  if(isset($_GET['sort_name']) && !isset($_GET['DESC']))
  {
    $order = ' ORDER BY username';
  }
  else if(isset($_GET['sort_name']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY username DESC';
  }
}
$result = $pdo->query("SELECT * FROM users". $order);

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
    <form action="list_user.php" method="GET">
        <div class="sort-options">
          <div class="sort-option">
              <input type="checkbox" name="sort_name" value="1" <?= isset($_GET['sort_name']) ? 'checked' : '' ?>>
              <label for="sort-ref">Utilisateurs</label>
          </div>
          <div class="sort-option">
              <input type="checkbox" name="DESC" value="1" <?= (isset($_GET['DESC']) && $_GET['DESC'] === '1') ? 'checked' : '' ?>>
              <label for="sort-desc">Décroissant</label>
          </div>
          <button type="submit" class="add-btn" style="color: white;">Valider</button>
        </div>
      </form>
      <button class="add-btn" id="addScooter">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
          </svg>
          <a href="add_user.php" style="text-decoration: none">Ajouter un utilisateur</a>
      </button>
    </div>
    <table>
      <thead>
        <tr>
          <th class="th">identifiant</th>
          <th class="th">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($client = $result->fetch(PDO::FETCH_ASSOC)) {
        ?>
          <tr>
            <td class="td"> <?php echo $client["username"]; ?></td>
            <td class="td">
              <a href="edit_user.php?username=<?php echo $client["username"] ?>">✏️</a>
              <a href="delete_user.php?username=<?php echo $client["username"]?>" onclick="return confirm('Supprimer ?')">🗑️</a>
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