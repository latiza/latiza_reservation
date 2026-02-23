<?php
// Időzóna beállítása
date_default_timezone_set('Europe/Budapest');

// Mai nap + aktuális hónap első napja
$today      = date('Y-m-d');
$monthStart = date('Y-m-01');

// "Előző időszak" mód URL-ből (?prev=1)
// Lazább ellenőrzés, hogy biztosan működjön
$includePast = isset($_GET['prev']) && $_GET['prev'] == '1';

// Adatbázis kapcsolódási adatok
require 'connect.php';

// Lekérdezés:
// - prev=1 esetén: MINDEN rekord
// - különben: csak az aktuális időszak (aktuális hónaptól)
if ($includePast) {
    $sql = "SELECT * FROM reservations
            ORDER BY start_date ASC";
} else {
    $sql = "SELECT * FROM reservations
            WHERE end_date >= '{$monthStart}'
            ORDER BY start_date ASC";
}

$result = $conn->query($sql);

// Foglalt időpontok tárolása tömbben
$reservations = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
}

$conn->close();

// Linkek biztosan a jelenlegi fájlra mutassanak
$self = htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tervezett útjaim</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/trips.css">
</head>
<body>
<?php include 'nav.php'; ?>

<h1 style="text-align:center; margin-top: 2rem;">Tervezett útjaim</h1>

<div class="toolbar">
    <a href="<?= $self ?>?prev=1" class="btn">
        Megvalósult utak betöltése
    </a>

    <?php if ($includePast) : ?>
        <a href="<?= $self ?>" class="btn-outline">
            Csak az aktuális időszak
        </a>
    <?php endif; ?>
</div>

<div class="container">
    <?php if (empty($reservations)): ?>
        <p style="text-align:center; margin-top:2rem;">Jelenleg nincs megjeleníthető út a választott időszakban.</p>
    <?php else: ?>
        <?php foreach ($reservations as $trip): ?>
            <div class="card">
                <div class="card-content">
                    <div class="trip-title"><?= htmlspecialchars($trip['destination']) ?></div>
                    <div class="trip-date">
                        <?= htmlspecialchars($trip['start_date']) ?> – <?= htmlspecialchars($trip['end_date']) ?>
                    </div>
                    <?php if (!empty($trip['notes'])): ?>
                        <a href="<?= htmlspecialchars($trip['notes']) ?>" target="_blank" rel="noopener">
                            <button class="details-button">Tovább a program részleteire</button>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
