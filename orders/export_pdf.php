<?php
require '../includes/fpdf186/fpdf.php';

require_once('../includes/connecionDB.php');
$commandes = "";

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $id_bon = 0;
    if (isset($_GET['id_bon'])) {
        $id_bon = $_GET['id_bon'];
    }
    $commandes = $pdo->query("SELECT b.id_bon,b.id_client, c.ref_scooter, c.quantite_cmd, c.remise,b.total_ht,b.tva,b.total_ttc,c.date_cmd  FROM bon_commande b JOIN contenir c on c.id_bon = b.id_bon where b.id_bon = $id_bon")->fetchAll(PDO::FETCH_ASSOC);
    $titre = "Facture";
} else {
    $commandes = $pdo->query("SELECT b.id_bon,b.id_client, c.ref_scooter, c.quantite_cmd,b.total_ht, c.remise, b.tva,b.total_ttc,c.date_cmd  FROM bon_commande b JOIN contenir c on c.id_bon = b.id_bon where b.id_bon = ")->fetchAll(PDO::FETCH_ASSOC);
    $titre = "Liste des commandes";
}
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, "$titre", 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetDisplayMode("fullwidth", "single");

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 10, 'ID Cmd', 1);
$pdf->Cell(30, 10, 'ID Client', 1);
$pdf->Cell(30, 10, 'Ref Scooter', 1);
$pdf->Cell(30, 10, 'Qte cmd', 1);
$pdf->Cell(30, 10, 'Total HT', 1);
$pdf->Cell(30, 10, 'Remise', 1);
$pdf->Cell(30, 10, 'TVA', 1);
$pdf->Cell(30, 10, 'Total TTC', 1);
$pdf->Cell(40, 10, 'Date', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
foreach ($commandes as $c) {
    $pdf->Cell(20, 10, $c['id_bon'], 1);
    $pdf->Cell(30, 10, $c['id_client'], 1);
    $pdf->Cell(30, 10, $c['ref_scooter'], 1);
    $pdf->Cell(30, 10, $c['quantite_cmd'], 1);
    $pdf->Cell(30, 10, $c['total_ht'], 1);
    $pdf->Cell(30, 10, $c['remise'], 1);
    $pdf->Cell(30, 10, $c['tva'], 1);
    $pdf->Cell(30, 10, $c['total_ttc'], 1);
    $pdf->Cell(40, 10, $c['date_cmd'], 1);
    $pdf->Ln();
}

$pdf->Output();
