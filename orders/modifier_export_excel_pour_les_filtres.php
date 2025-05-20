<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=commandes_filtrees.xls");

$pdo = new PDO("mysql:host=localhost;dbname=getscooter", "root", "");

$where = [];
$params = [];

if (!empty($_GET['start_date'])) {
  $where[] = "date_commande >= ?";
  $params[] = $_GET['start_date'];
}
if (!empty($_GET['end_date'])) {
  $where[] = "date_commande <= ?";
  $params[] = $_GET['end_date'];
}
if (!empty($_GET['statut'])) {
  $where[] = "statut = ?";
  $params[] = $_GET['statut'];
}

$sql = "SELECT * FROM commandes";
if ($where) {
  $sql .= " WHERE " . implode(" AND ", $where);
}
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$commandes = $stmt->fetchAll();

echo "<table border='1'>";
echo "<tr><th>ID</th><th>Client</th><th>Scooter</th><th>Date</th><th>Statut</th></tr>";
foreach ($commandes as $c) {
  echo "<tr>
    <td>{$c['id']}</td>
    <td>{$c['client_id']}</td>
    <td>{$c['scooter_id']}</td>
    <td>{$c['date_commande']}</td>
    <td>{$c['statut']}</td>
  </tr>";
}
echo "</table>";
?>
