<?php 
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../index.php");
  exit();
}
    include_once("../includes/connecionDB.php");

    $id_client = "";
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

    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        if(!isset($_GET['id_client']))
        {
            header("location: ./list_client.php");
            exit;
        }
        $id_client = $_GET["id_client"];
        
        $req = "SELECT * FROM client where id_client = $id_client";
        $result = $pdo->query($req);
        $row = $result->fetch();

        if(!$row)
        {
            header("location: ./list_client.php");
            exit;   
        }
        $name = $row['nom'];
        $firstname = $row['prenom'];
        $phone = $row['phone'];
        $cin = $row['cin'];
        $pays = $row['pays'];
        $ville = $row['ville'];
        $date_naiss = $row['date_naiss'];
    }
    else
    {
        $id_client = $_POST['id_client'];
        $name = $_POST['nom'];
        $firstname = $_POST['prenom'];
        $phone = $_POST['phone'];
        $cin = $_POST['cin'];
        $pays = $_POST['pays'];
        $ville = $_POST['ville'];
        $date_naiss = $_POST['date_naiss'];

        do
        {
            if( empty($id_client) || empty($name) || empty($firstname) || empty($phone)  || empty($cin) || empty($pays) || empty($ville) || empty($date_naiss))
            {
                $errorMessage = "Tous les champs sont obligatoires !!";
                break;
            }

            $query = "UPDATE client set nom = '$name', prenom = '$firstname', phone = '$phone', cin = '$cin', pays = '$pays', ville = '$ville', date_naiss = '$ville' where id_client = $id_client";

            $result = $pdo->query($query);
            if(!$result)
            {
                $errorMessage = "Invalid query : ".$pdo->errorInfo();
                break;
            }

            include_once("../includes/log.php");
            logActivity($_SESSION['user'], "Mis à jour d'un client");
            $successMessge= "Client mis à jour";

            header("location:./list_client.php");
            exit;
        }
        while(false);
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
  <form id="scooter-form" action="add_client.php" method="POST">
    <div class="input-group">
        <input type="hidden" name="id_client" value="<?php $id_client ?>">
    </div>
    <div class=input-group>
      <label for="nom">Nom</label>
      <input type="text" name="nom" placeholder="nom" value="<?php echo $name ?>" required>
    </div>
    <div class=input-group>
      <label for="prenom">Prenom</label>
      <input type="text" name="prenom" placeholder="prénom" value="<?php echo $firstname?>" required>
    </div>
    <div class=input-group>
      <label for="phone">Phone</label>
      <input type="text" name="phone" placeholder="phone" value="<?php echo $phone ?>" required>
    </div>
    <div class=input-group>
      <label for="cin">CIN</label>
      <input type="text" name="cin" placeholder="cin" value="<?php echo $cin ?>" required>
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
