<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}
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


    $quantite_stock = 0;
    $res = "SELECT quantite_stock as nombre FROM scooter WHERE ref_scooter = '$ref_scooter'";
    $quant = $pdo->query($res);
    $resultat = $quant->fetch();
    $quantite_stock = $resultat['nombre'];
    if ($quantite_stock < $quantite_cmd) {
        echo "<script> alert('Quantité insuffisant');
                    const url = new URL(window.location);
                    url.searchParams.delete('quantity');
                    window.history.replaceState({}, document.title, url);
                    window.location.reload();
                </script>";
        exit;
    }
    $pdo->beginTransaction();
    try {
        $stm1 = $pdo->prepare("INSERT INTO bon_commande (id_client, total_ht, tva, total_ttc) VALUES (?, ?, ?, ?)");
        $stm1->execute([$id_client, $total_ht, $tva, $total_ttc]);
        $id_bon = $pdo->lastInsertId();
        $stm2 = $pdo->prepare("INSERT INTO contenir (ref_scooter, id_bon, quantite_cmd, date_cmd, remise, total_prix) VALUES(?, ?, ?, ?, ?, ?)");
        $stm2->execute([$ref_scooter, $id_bon, $quantite_cmd, $date_cmd, $remise, $total_prix]);
        $pdo->commit();

        $newquant = $quantite_stock - $quantite_cmd;
        $req1 = "UPDATE scooter SET quantite_stock = $newquant WHERE ref_scooter = '$ref_scooter' ";
        $pdo->query($req1);

        include_once("../includes/log.php");
        logActivity($_SESSION['user'], "Ajout d'un commande");
        echo "Commande enregisté avec succès";
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
                    <div class=input-group>
                        <label for="id_client">Id_client</label>
                        <select name="id_client" id="id_client">
                            <option value="" disabled selected>--Séléctionner un client --</option>
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
                            <option value="" disabled selected>--Séléctionner un scooter --</option>
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
                        <input type="number" name="quantite" placeholder="quantite commande" id="quantite" value="<?php echo $quantite ?>" required>
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
                        <input type="text" name="" placeholder="Total après remise" id="totalRemise" readonly>
                    </div>
                    <div class=input-group>
                        <label for="modele">TVA %</label>
                        <input type="text" name="tva" placeholder="tva" value="<?php echo $tva ?>" readonly>
                    </div>
                    <div class=input-group>
                        <label for="modele">Total TTC</label>
                        <input type="text" name="total_ttc" placeholder="Total TTC" id="ttc" value="<?php echo $total_ttc ?>" readonly>
                    </div>
                    <div class="btn">
                        <button class="submit-btn" type="submit">Ajouter</button>
                        <button class="refresh-btn" type="reset">Reset</button>
                    </div>
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