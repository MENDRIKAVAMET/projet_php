<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}
$id_bon = "";
$id_client = "";
$total_ht = "";
$tva = "20";
$total_ttc = "";
$ref_scooter = "";
$id_bon = "";
$quantite_cmd = "";
$date_cmd = date('Y-m-d');
$remise = "";
$total_prix = "";

$errorMessage = "";
$successMessge = "";


include_once("../includes/connecionDB.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $id_client = $_POST['id_client'];
    $total_ht = $_POST['total_ht'];
    $total_ttc = $_POST['total_ttc'];
    $ref_scooter = $_POST['ref_scooter'];
    $quantite_cmd = $_POST['quantite'];
    $remise = $_POST['remise'];
    $total_prix = $total_ht;

    $pdo->beginTransaction();
    try {
        $stm1 = $pdo->prepare("UPDATE bon_commande set id_client = ?, total_ht = ?, tva = ?, total_ttc ? where id_bon = ? ");
        $stm1->execute([$id_client, $total_ht, $tva, $total_ttc, $id_bon]);
        $stm2 = $pdo->prepare("UPDATE contenir set ref_scooter = ?, quantite_cmd = ?, date_cmd = ?, remise = ?, total_prix = ?  where id_bon = ?");
        $stm2->execute([$ref_scooter, $quantite_cmd, $date_cmd, $remise, $total_prix, $id_bon]);
        $pdo->commit();
        include_once("../includes/log.php");
        logActivity($_SESSION['user'], "Mis à jour d'un commande");
        echo "Commande mis à jour";
        header("location: ./list_order.php");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
} else {
    $stm = $pdo->query("SELECT ref_scooter, marque, prix FROM scooter order by ref_scooter");
    $scooter = $stm->fetchAll();

    $stm2 = $pdo->query("SELECT id_client, nom, prenom FROM client order by nom");
    $client = $stm2->fetchAll();

    if (!isset($_GET['id_bon'])) {
        header("location: ./list_order.php");
        exit;
    }
    $id_bon = $_GET['id_bon'];
    $req = "SELECT b.id_bon,b.id_client,b.total_ht,c.ref_scooter,b.total_ttc,c.date_cmd, c.quantite_cmd, c.remise  FROM bon_commande b JOIN contenir c on c.id_bon = b.id_bon where b.id_bon = $id_bon";
    $result = $pdo->query($req);
    $row = $result->fetch();

    if (!$row) {
        header("location: ./list_order.php");
        exit;
    }

    $id_bon = $row['id_bon'];
    $id_client = $row['id_client'];
    $total_ht = $row['total_ht'];
    $total_ttc = $row['total_ttc'];
    $ref_scooter = $row['ref_scooter'];
    $quantite_cmd = $row['quantite_cmd'];
    $remise = $row['remise'];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un scooter</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">
</head>

<body>

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
                <h2>Commande</h2>
                <form id="scooter-form" action="add_order.php" method="POST">
                    <div class="input-group">
                        <input type="hidden" name="id_bon" value="<?php echo $id_bon ?>">
                    </div>
                    <div class=input-group>
                        <label for="id_client">Id_client</label>
                        <select name="id_client" id="id_client">
                            <option value="<?php echo $id_client ?>" disabled selected>--Séléctionner un client --</option>
                            <?php foreach ($client as $c): ?>
                                <option value="<?= htmlspecialchars($c['id_client']) ?>">
                                    <?= htmlspecialchars($c['id_client']) ?> - <?= htmlspecialchars($c['nom']) ?> - <?= htmlspecialchars($c['prenom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class=input-group>
                        <label for="ref_scooter">Référence du scooter</label>
                        <select name="ref_scooter" id="scooter-select">
                            <option value="<?php echo $ref_scooter ?>" disabled selected>--Séléctionner un scooter --</option>
                            <?php foreach ($scooter as $s): ?>
                                <option
                                    value="<?= $s['ref_scooter'] ?>"
                                    data-prix="<?= $s['prix'] ?>">
                                    <?= htmlspecialchars($s['ref_scooter']) ?> - <?= htmlspecialchars($s['marque']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class=input-group>
                        <label for="prix">Prix unitaire</label>
                        <input type="text" name="prix" placeholder="Prix unitaire" id="prix" readonly>
                    </div>
                    <div class=input-group>
                        <label for="marque">Quantite commande</label>
                        <input type="number" name="quantite" placeholder="quantite commande" id="quantite" value="<?php echo $quantite_cmd ?>" required>
                    </div>
                    <div class=input-group>
                        <label for="prix">Total ht</label>
                        <input type="text" name="total_ht" placeholder="Total ht" id="ht" value="<?php echo $total_ht ?>" readonly>
                    </div>
                    <div class=input-group>
                        <label for="quantite">Remise %</label>
                        <input type="number" name="remise" placeholder="Remise%" id='remise' value="<?php echo $remise ?>" required>
                    </div>
                    <div class=input-group>
                        <label for="Total Remise">Total après remise</label>
                        <input type="text" name="" placeholder="Total après remise" id="totalRemise" value="<?php echo $total_ht * (($total_ht * $remise) / 100) ?>" readonly>
                    </div>
                    <div class=input-group>
                        <label for="modele">TVA %</label>
                        <input type="text" name="tva" placeholder="tva" value="<?php echo $tva ?>" readonly>
                    </div>
                    <div class=input-group>
                        <label for="modele">Total TTC</label>
                        <input type="text" name="total_ttc" placeholder="Total TTC" id="ttc" value="<?php echo $total_ttc ?>" readonly>
                    </div>
                    <button type="submit">Ajouter</button>
                    <button type="reset">Reset</button>
                </form>
            </div>
        </main>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var prix = 0;
                var quantite = 0;
                var ht = 0;
                var remise = 0;
                var totalRemise = 0;
                var ttc = 0;
                document.getElementById('scooter-select').addEventListener('change', function() {
                    prix = parseFloat(this.options[this.selectedIndex].getAttribute('data-prix'));
                    document.getElementById('prix').value = prix ? prix : "";
                });
                document.getElementById('quantite').addEventListener('input', function() {
                    quantite = parseInt(this.value);
                    ht = prix * quantite;
                    document.getElementById('ht').value = ht ? ht : "";
                });
                document.getElementById('remise').addEventListener('input', function() {
                    remise = parseFloat(this.value) / 100;
                    totalRemise = ht - (ht * remise);
                    document.getElementById('totalRemise').value = totalRemise ? totalRemise : "";
                    var tva = 0.2;
                    ttc = totalRemise + (totalRemise * tva);
                    document.getElementById('ttc').value = ttc ? ttc : "";
                });
            });
        </script>
    </body>

</html>