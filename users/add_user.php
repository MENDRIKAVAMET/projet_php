<?php 
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../index.php");
  exit();
}
    $username = "";
    $mdp = "";

    $errorMessage = "";
    $successMessge = "";

    if($_SERVER['REQUEST_METHOD'] === "POST")
    {
        $username = $_POST['username'];
        $mdp = $_POST['mdp'];

        do
        {
            if(empty($username) || empty($mdp))
            {
                $errorMessage = "Tous les champs sont obligatoires !!";
                break;
            }
            include_once("../includes/connecionDB.php");
            $req = "INSERT INTO users(username, mdp) values
            ('$username', '$mdp')";
            $result = $pdo->query($req);
            if(!$result)
            {
              $errorMessage = "Invalid query : ".$pdo->errorInfo();
              break;
            }

            $username = "";
            $mdp = "";

            include_once("../includes/log.php");
            logActivity($_SESSION['user'], "Ajout d'un utilisateur");
            $successMessge = "Utilisateur ajouté avec succès";
            header("location: ./list_user.php");
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
  <h2>Client</h2>
  <form id="scooter-form" action="add_user.php" method="POST">
    <div class=input-group>
      <label for="username">Nom</label>
      <input type="text" name="username" placeholder="username" value="<?php echo $username ?>" required>
    </div>
    <div class=input-group>
      <label for="mdp">Mot de passe</label>
      <input type="password" name="mdp" placeholder="mot de passe" value="<?php echo $mdp?>" required>
    </div>
    
    <?php 
      if(!empty($successMessge))
      {
        echo"<div class='success'>
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
