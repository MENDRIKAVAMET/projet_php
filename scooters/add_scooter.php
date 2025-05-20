<?php 
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../index.php");
  exit();
}
    $ref = "";
    $marque = "";
    $modele = "";
    $prix = "";
    $quantite = "";

    $errorMessage = "";
    $successMessge = "";

    if($_SERVER['REQUEST_METHOD'] === "POST")
    {
        $ref = $_POST['ref_scooter'];
        $marque = $_POST['marque'];
        $modele = $_POST['modele'];
        $prix = $_POST['prix'];
        $quantite = $_POST['quantite'];

        do
        {
            if(empty($ref) || empty($marque) || empty($modele)  || empty($prix) || empty($quantite))
            {
                $errorMessage = "Tous les champs sont obligatoires !!";
                break;
            }
            include_once("../includes/connecionDB.php");
            $req = "INSERT INTO scooter VALUES('$ref','$marque','$modele',$prix, $quantite)";
            $result = $pdo->query($req);
            if(!$result)
            {
              $errorMessage = "Invalid query : ".$pdo->errorInfo();
              break;
            }

            
            $ref = "";
            $marque = "";
            $modele = "";
            $prix = "";
            $quantite = "";
            
            include_once("../includes/log.php");
            logActivity($_SESSION['user'], "Ajout d'un scooter");
            $successMessge = "Scooter ajouté avec succès";
            header("location: list_scooter.php");
            exit;
        }while(false);
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un scooter</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>" >
</head>
<body>
<body class="body-container">
<?php require_once("../includes/menu_lateral_nav.php"); ?>

<main>
<?php  if (!empty($errorMessage))
{
    echo"<div class='error'>
        <strong>$errorMessage</strong>
    </div>";
}
?>
<div class="form-container">
  <h2>Scooter</h2>
  <form id="scooter-form" action="add_scooter.php" method="POST">
    <div class=input-group>
      <label for="ref_scooter">Référence</label>
      <input type="text" name="ref_scooter" placeholder="Référence de scooter" value = "<?php echo $ref ?>" required>
    </div>
    <div class=input-group>
      <label for="marque">Marque</label>
      <input type="text" name="marque" placeholder="marque" value = "<?php echo $marque ?>" required>
    </div>
    <div class=input-group>
      <label for="modele">Modèle</label>
      <input type="text" name="modele" placeholder="modèle" value = "<?php echo $modele ?>" required>
    </div>
    <div class=input-group>
      <label for="prix">Prix</label>
      <input type="number" name="prix" placeholder="prix" value = "<?php echo $prix ?>" required>
    </div>
    <div class=input-group>
      <label for="quantite">Quantite à stocker</label>
      <input type="number" name="quantite" placeholder="quantite à stocker" value = "<?php echo $quantite ?>" required>
    </div>
    <div class="btn">
      <button class="submit-btn" type="submit">Ajouter</button>
      <button class ="refresh-btn" type="reset">Reset</button>
    </div>
  </form>
</div>
</main>
</body>
</html>
