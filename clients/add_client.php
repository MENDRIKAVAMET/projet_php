<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../index.php");
  exit();
}
$name = "";
$firstname = "";
$phone = "";
$email = "";
$cin = "";
$pays = "";
$ville = "";
$date_naiss = "";

$errorMessage = "";
$successMessge = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $name = $_POST['nom'];
  $firstname = $_POST['prenom'];
  $phone = $_POST['phone'];
  $cin = $_POST['cin'];
  $pays = $_POST['pays'];
  $ville = $_POST['ville'];
  $date_naiss = $_POST['date_naiss'];

  do {
    if (empty($name) || empty($firstname) || empty($phone)  || empty($cin) || empty($pays) || empty($ville) || empty($date_naiss)) {
      $errorMessage = "Tous les champs sont obligatoires !!";
      break;
    }
    include_once("../includes/connecionDB.php");
    $req = "INSERT INTO client (nom, prenom, phone, cin ,pays, ville, date_naiss) values
            ('$name', '$firstname', '$phone', '$cin', '$pays', '$ville', '$date_naiss')";
    $result = $pdo->query($req);
    if (!$result) {
      $errorMessage = "Invalid query : " . $pdo->errorInfo();
      break;
    }

    $name = "";
    $firstname = "";
    $phone = "";
    $email = "";
    $cin = "";
    $pays = "";
    $ville = "";
    $date_naiss = "";

    include_once("../includes/log.php");
    logActivity($_SESSION['user'], "Ajout d'un client");
    $successMessge = "Client ajouté avec succès";
    header("location: ./list_client.php");
    exit;
  } while (false);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Ajouter un scooter</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">
</head>

<body class="body-container">
  <?php require_once("../includes/menu_lateral_nav.php"); ?>

  <main>
    <?php if (!empty($errorMessage)) {
      echo "<div class='error'>
        <strong>$errorMessage</strong>
    </div>";
    }
    ?>
    <div class="form-container">
      <h2>Client</h2>
      <form id="scooter-form" action="add_client.php" method="POST">
        <div class=input-group>
          <label for="nom">Nom</label>
          <input type="text" name="nom" placeholder="nom" value="<?php echo $name ?>" required>
        </div>
        <div class=input-group>
          <label for="prenom">Prenom</label>
          <input type="text" name="prenom" placeholder="prénom" value="<?php echo $firstname ?>" required>
        </div>
        <div class=input-group>
          <label for="phone">Phone</label>
          <input type="text" name="phone" placeholder="phone" value="<?php echo $phone ?>" required maxlength="10" minlength="10">
        </div>
        <div class=input-group>
          <label for="cin">CIN</label>
          <input type="text" name="cin" placeholder="cin" value="<?php echo $cin ?>" required maxlength="12" minlength="10">
        </div>
        <div class=input-group>
          <label for="pays">Pays</label>
          <input type="text" name="pays" placeholder="pays" value="<?php echo $pays ?>" required>
        </div>
        <div class=input-group>
          <label for="ville">Ville</label>
          <input type="text" name="ville" placeholder="ville" value="<?php echo $ville ?>" required>
        </div>
        <div class=input-group>
          <label for="date_naisse">Date de naissance</label>
          <input type="date" name="date_naiss" placeholder="date_naiss" value="<?php $date_naiss ?>" required>
        </div>

        <?php
        if (!empty($successMessge)) {
          echo "<div class='success'>
        <strong>$successMessge</strong>
        </div>";
        }
        ?>
        <div class="btn">
          <button class="submit-btn" type="submit">Ajouter</button>
          <button class="refresh-btn" type="reset">Reset</button>
        </div>
      </form>
    </div>
  </main>
</body>

</html>