<form method="GET" action="list.php" class="filter-form">
  <label>De : <input type="date" name="start_date" value="<?= $_GET['start_date'] ?? '' ?>"></label>
  <label>À : <input type="date" name="end_date" value="<?= $_GET['end_date'] ?? '' ?>"></label>
  <label>Statut :
    <select name="statut">
      <option value="">-- Tous --</option>
      <option value="en attente" <?= ($_GET['statut'] ?? '') == 'en attente' ? 'selected' : '' ?>>En attente</option>
      <option value="livré" <?= ($_GET['statut'] ?? '') == 'livré' ? 'selected' : '' ?>>Livré</option>
      <option value="annulé" <?= ($_GET['statut'] ?? '') == 'annulé' ? 'selected' : '' ?>>Annulé</option>
    </select>
  </label>
  <button type="submit">Filtrer</button>
</form>

<!-- Export Buttons (on garde les filtres dans les URL) -->
<div class="export-buttons">
  <?php
    $params = http_build_query($_GET);
  ?>
  <a href="export_excel.php?<?= $params ?>" class="btn">📥 Export Excel</a>
  <a href="export_pdf.php?<?= $params ?>" class="btn">📄 Export PDF</a>
</div>
