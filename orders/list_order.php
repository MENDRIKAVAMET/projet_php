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
  if(isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && isset($_GET['ttc']) && isset($_GET['date']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon DESC, b.id_client DESC, b.total_ht DESC, tva DESC, b.total_ttc DESC, c.date_cmd DESC';
  }
  else if(isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && isset($_GET['ttc']) && isset($_GET['date']) && !isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon, b.id_client, b.total_ht, tva, b.total_ttc, c.date_cmd';
  }
  else if(isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && isset($_GET['ttc']) && !isset($_GET['date']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon DESC, b.id_client DESC, b.total_ht DESC, tva DESC, b.total_ttc DESC';
  }
  else if(isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && isset($_GET['ttc']) && !isset($_GET['date']) && !($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon, b.id_client, b.total_ht, tva, b.total_ttc';
  }
  else if(isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && !isset($_GET['ttc']) && isset($_GET['date']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon DESC, b.id_client DESC, b.total_ht DESC, tva DESC, c.date_cmd DESC';
  }
  else if(isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && !isset($_GET['ttc']) && isset($_GET['date']) && !isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon, b.id_client, b.total_ht, tva, c.date_cmd';
  }
  else if(isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && !isset($_GET['tva']) && isset($_GET['ttc']) && isset($_GET['date']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon DESC, b.id_client DESC, b.total_ht DESC, c.date_cmd DESC, b.total_ttc DESC';
  }
  else if(isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && isset($_GET['ttc']) && !isset($_GET['date']) && !isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon , b.id_client , b.total_ht , c.date_cmd, b.total_ttc';
  }
  else if(isset($_GET['id_commande']) && isset($_GET['id_client']) && !isset($_GET['ht']) && isset($_GET['tva']) && isset($_GET['ttc']) && isset($_GET['date']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon DESC, b.id_client DESC, c.date_cmd DESC, tva DESC, b.total_ttc DESC';
  }
  else if(isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && isset($_GET['ttc']) && isset($_GET['date']) && !isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon, b.id_client, c.date_cmd, tva, b.total_ttc';
  }
  else if(isset($_GET['id_commande']) && !isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && isset($_GET['ttc']) && isset($_GET['date']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon DESC, c.date_cmd DESC, b.total_ht DESC, tva DESC, b.total_ttc DESC';
  }
  else if(isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && isset($_GET['ttc']) && isset($_GET['date']) && !isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon, c.date_cmd, b.total_ht, tva, b.total_ttc';
  }
  else if(!isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && isset($_GET['ttc']) && isset($_GET['date']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY c.date_cmd DESC, b.id_client DESC, b.total_ht DESC, tva DESC, b.total_ttc DESC';
  }
  else if(!isset($_GET['id_bon']) && isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && isset($_GET['ttc']) && isset($_GET['date']) && !isset($_GET['DESC']))
  {
    $order = ' ORDER BY c.date_cmd, b.id_client, b.total_ht, tva, b.total_ttc';
  }
  else if(isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && !isset($_GET['ttc']) && !isset($_GET['date']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon DESC, b.id_client DESC, b.total_ht DESC, tva DESC';
  }
  else if(isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && !isset($_GET['tva']) && isset($_GET['ttc']) && !isset($_GET['date']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon DESC, b.id_client DESC, b.total_ht DESC, b.total_ttc DESC';
  }
  else if(isset($_GET['id_commande']) && isset($_GET['id_client']) && !isset($_GET['ht']) && isset($_GET['tva']) && isset($_GET['ttc']) && !isset($_GET['date']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon DESC, b.id_client DESC, b.total_ttc DESC, tva DESC';
  }
  else if(isset($_GET['id_commande']) && !isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && isset($_GET['ttc']) && !isset($_GET['date']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon DESC, b.total_ttc DESC, b.total_ht DESC, tva DESC';
  }
  else if(!isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && isset($_GET['ttc']) && !isset($_GET['date']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY b.total_ttc DESC, b.id_client DESC, b.total_ht DESC, tva DESC';
  }
  else if(isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && !isset($_GET['ttc']) && !isset($_GET['date']) && !isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon, b.id_client, b.total_ht, tva';
  }
  else if(isset($_GET['id_bon']) && isset($_GET['id_client']) && isset($_GET['ht']) && !isset($_GET['tva']) && isset($_GET['ttc']) && !isset($_GET['date']) && !isset($_GET['DESC']))
  {
    $order = ' ORDER BY id_bon, b.id_client, b.total_ht, b.total_ttc';
  }
  else if(isset($_GET['id_commande']) && isset($_GET['id_client']) && isset($_GET['ht']) && isset($_GET['tva']) && !isset($_GET['ttc']) && !isset($_GET['date']) && !isset($_GET['DESC']))
  {
    $order = ' ORDER BY b.id_bon, b.id_client, b.total_ht, tva';
  }
  else if(isset($_GET['id_commande']) && !isset($_GET['id_client']) && !isset($_GET['ht']) && !isset($_GET['tva']) && !isset($_GET['ttc']) && !isset($_GET['date']) && !isset($_GET['DESC']))
  {
    $order = ' ORDER BY b.id_bon';
  }else if(isset($_GET['id_commande']) && !isset($_GET['id_client']) && !isset($_GET['ht']) && !isset($_GET['tva']) && !isset($_GET['ttc']) && !isset($_GET['date']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY b.id_bon DESC';
  }
  else if(isset($_GET['id_client']))
  {
    $order = ' ORDER BY b.id_client';
  }
  else if(isset($_GET['id_client']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY b.id_client DESC';
  }
  else if(isset($_GET['ht']))
  {
    $order = ' ORDER BY b.total_ht';
  }
  else if(isset($_GET['ht']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY b.total_ht DESC';
  }
  else if(isset($_GET['tva']))
  {
    $order = ' ORDER BY b.tva';
  }
  else if(isset($_GET['tva']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY b.tva DESC';
  }
  else if(isset($_GET['ttc']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY b.total_ttc DESC';
  }
  else if(isset($_GET['ttc']))
  {
    $order = ' ORDER BY b.total_ttc';
  }
  else if(isset($_GET['date']) && isset($_GET['DESC']))
  {
    $order = ' ORDER BY c.date_cmd DESC';
  }
  else if(isset($_GET['date']))
  {
    $order = ' ORDER BY c.date_cmd';
  }
}
$result = $pdo->query("SELECT b.id_bon,b.id_client,b.total_ht,b.tva,b.total_ttc,c.date_cmd  FROM bon_commande b JOIN contenir c on c.id_bon = b.id_bon".$order);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Orders - GetScooter</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?> ">
</head>

<body>
  <?php require_once("../includes/menu_lateral_nav.php"); ?>

  <div class="container">
    <div class="controls">
      <form action="list_order.php" method="GET">
      <div class="sort-options">
        <div class="sort-option">
          <input type="checkbox" name="id_commande" value="1" <?= isset($_GET['id_commande']) ? 'checked' : '' ?>>
          <label for="sort-idCommand">ID Commande</label>
        </div>
        <div class="sort-option">
          <input type="checkbox" name="id_client" value="1" <?= isset($_GET['id_client']) ? 'checked':'' ?>>
          <label for="sort-idClient">ID Client</label>
        </div>
        <div class="sort-option">
          <input type="checkbox" name="ht" value="1" <?= isset($_GET['ht']) ? 'checked':'' ?>>
          <label for="sort-ht">Total HT</label>
        </div>
        <div class="sort-option">
          <input type="checkbox" name="tva" value="1" <?= isset($_GET['tva']) ? 'checked':'' ?>>
          <label for="sort-tva">TVA</label>
        </div>
        <div class="sort-option">
          <input type="checkbox" name="ttc" value="1" <?= isset($_GET['ttc']) ? 'checked' : '' ?>>
          <label for="sort-ttc">Total TTC</label>
        </div>
        <div class="sort-option">
          <input type="checkbox" name="date" value="1" <?=isset($_GET['date']) ? 'checked' : '' ?>>
          <label for="sort-date">Date Commande</label>
        </div>

        <div class="sort-option">
          <input type="checkbox" name="DESC" value="1" <?= (isset($_GET['DESC']) && $_GET['DESC'] === '1') ? 'checked' : '' ?>>
          <label for="sort-date">Décroissant</label>
        </div>
        <button type="submit" style="color: white;" class="add-btn">Valider</button>
      </div>
      </form>

      <button class="add-btn" id="addOrder">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="5" x2="12" y2="19"></line>
          <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        <a href="add_order.php" style="text-decoration: none">Ajouter un commande</a>
      </button>
    </div>
    <table>
      <thead>
        <tr>
          <th>ID Commande</th>
          <th>ID Client</th>
          <th>Total HT</th>
          <th>TVA</th>
          <th>Total TTC</th>
          <th>Date de commande</th>
          <th style="text-align: center;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($scooter = $result->fetch()) {
        ?>
          <tr>
            <td> <?php echo $scooter["id_bon"]; ?></td>
            <td> <?php echo $scooter["id_client"]; ?></td>
            <td> <?php echo $scooter["total_ht"]; ?></td>
            <td> <?php echo $scooter["tva"]; ?></td>
            <td> <?php echo $scooter["total_ttc"]; ?></td>
            <td> <?php echo $scooter["date_cmd"]; ?></td>
            <td>
              <a style="color: orange; text-decoration: none;" href="edit_order.php?id_bon=<?php echo $scooter["id_bon"] ?>">✏️Edit</a>
              <a style="color: red; text-decoration: none;"href="delete_order.php?id_bon=<?php echo $scooter["id_bon"] ?>" onclick="return confirm('Supprimer ?')">🗑️Delete</a>
              <a style="color: blueviolet; text-decoration: none;"href="export_excel.php?id_bon= <?php echo $scooter["id_bon"] ?>">📥Excel</a>
              <a style="color: blueviolet; text-decoration: none;"href="export_pdf.php?id_bon=<?php echo $scooter["id_bon"]?>">📄Pdf</a>
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