<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=commandes.xls");

include_once("../includes/connecionDB.php");
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $id_bon = 0;
    if (isset($_GET['id_bon'])) {
        $id_bon = $_GET['id_bon'];
    }
    $commandes = $pdo->query("SELECT b.id_bon,b.id_client, c.ref_scooter, c.quantite_cmd, c.remise,b.total_ht,b.tva,b.total_ttc,c.date_cmd  FROM bon_commande b JOIN contenir c on c.id_bon = b.id_bon where b.id_bon = $id_bon")->fetchAll(PDO::FETCH_ASSOC);
} else {
    $commandes = $pdo->query("SELECT b.id_bon,b.id_client, c.ref_scooter, c.quantite_cmd,b.total_ht, c.remise, b.tva,b.total_ttc,c.date_cmd  FROM bon_commande b JOIN contenir c on c.id_bon = b.id_bon where b.id_bon = ")->fetchAll(PDO::FETCH_ASSOC);
}

echo "<table border='1'>";
echo "<tr><th>ID</th><th>Id Commande</th><th>Id Client</th><th>Ref Scooter</th><th>Quantite commande</th><th>Remise</th><th>Total HT</th><th>TVA</th><th>Total TTC</th><th>Date</th></tr>";
foreach ($commandes as $commande) {
    echo "<tr>
        <td>{$commande['id_bon']}</td>
        <td>{$commande['id_client']}</td>
        <td>{$commande['ref_scooter']}</td>
        <td>{$commande['quantite_cmd']}</td>
        <td>{$commande['remise']}</td>
        <td>{$commande['total_ht']}</td>
        <td>{$commande['tva']}</td>
        <td>{$commande['total_ttc']}</td>
        <td>{$commande['date_cmd']}</td>
    </tr>";
}
echo "</table>";
