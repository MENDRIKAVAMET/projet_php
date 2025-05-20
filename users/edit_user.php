<?php 
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../index.php");
  exit();
}
    $oldusername = "";
    $username = "";
    $mdp = "";

    $errorMessage = "";
    $successMessge = "";

    require_once('../includes/connecionDB.php');
    if($_SERVER['REQUEST_METHOD'] === "GET")
    {
        if(!isset($_GET['username']))
        {
            header('location: ./list_user.php');
            exit;
        }

        $username = $_GET['username'];
        $oldusername = $username;
        $req = "SELECT * FROM users where username = '$username'";
        $result = $pdo->query($req);
        $row = $result->fetch();
        if(!$row)
        {
            header('location: ./list_user.php');
            exit;
        }
    }
    else
    {
        $username = $_POST['username'];
        $mdp = $_POST['mdp'];
        do
        {
            $query = "UPDATE users set username = '$username', mdp = '$mdp' where username = '$oldusername'";
            $result = $pdo->query($query);
            if(!$result)
            {
                $errorMessage = "Invalid query ".$pdo->errorInfo();
                break;
            }

            include_once("../includes/log.php");
            logActivity($_SESSION['user'], "Mis à jour d'un utilisateur");
            $successMessge = "Utilisateur mis à jour";
            
            header('location: ./list_user.php');
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
    <button type="submit">Ajouter</button>
    <button type="reset">Reset</button>
  </form>
</div>
</main>
</body>
</html>
