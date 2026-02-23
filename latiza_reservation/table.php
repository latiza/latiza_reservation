<?php
session_start();
// Ellenőrizzük, hogy be van-e lépve a felhasználó
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

// Időzóna + dátum logika (ugyanaz, mint calendar.php / trips.php)
date_default_timezone_set('Europe/Budapest');

$today      = date('Y-m-d');
$monthStart = date('Y-m-01');

// "Előző időszak" mód URL-ből (?prev=1)
$includePast = isset($_GET['prev']) && $_GET['prev'] === '1';

// Ettől az évtől visszafelé már nem foglalkozunk (mint a naptárnál)
$startYear = max(2025, (int)date('Y'));

// Alsó határ: ha prev=1, akkor az év elejétől, egyébként az aktuális hónap elejétől
$listLowerBound = $includePast
    ? sprintf('%d-01-01', $startYear)   // pl. 2025-01-01
    : $monthStart;

require 'connect.php';
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foglalt időpontok</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="css/table.css">
    <script>
        function sortTable(columnIndex) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("reservationTable");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[columnIndex];
                    y = rows[i + 1].getElementsByTagName("TD")[columnIndex];
                    if (dir === "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir === "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount === 0 && dir === "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
</head>
<body>
<nav>
    <ul>
        <li><a href="reservation.php">Felvitel</a></li>
        <li><a href="calendar.php">Naptár</a></li>
        <li><a href="table.php">Táblázat</a></li>
        <li><a href="logout.php">Kilépés</a></li>
    </ul>
</nav>

<h2>Foglalt időpontok</h2>

<!-- Ugyanaz a logika, mint a naptárnál / tervezett utaknál -->
<div class="toolbar">
    <a href="?prev=1" class="btn">
        Megvalósult utak betöltése
    </a>
    <?php if (!empty($includePast)) : ?>
        <a href="?" class="btn-outline">
            Csak az aktuális időszak
        </a>
    <?php endif; ?>
</div>

<table id="reservationTable">
    <thead>
    <tr>
        <th onclick="sortTable(1)">Utazási iroda</th>
        <th onclick="sortTable(2)">Utazás neve</th>
        <th onclick="sortTable(3)">Megjegyzés</th>
        <th onclick="sortTable(0)">Kezdés dátuma</th>
        <th onclick="sortTable(4)">Vége dátuma</th>
        <th onclick="sortTable(5)">Napok száma</th>
        <th>Módosítás</th>
        <th>Törlés</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // Lekérdezés: csak azok a foglalások, ahol a VÉGE dátum nem régebbi, mint a beállított alsó határ
    $sql = "SELECT * FROM reservations 
            WHERE end_date >= '{$listLowerBound}'
            ORDER BY start_date ASC";
    $result = $conn->query($sql);

    $reservations = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reservations[] = $row;
        }
    }

    // Kapcsolat bezárása
    $conn->close();

    // Kiírjuk a foglalt időpontokat a táblázatba
    foreach ($reservations as $reservation) {
        echo "<tr";
        if ($_SESSION['user_id'] == $reservation['user_id']) echo ' class="reserved"';
        echo ">";

        // Utazási iroda neve user_id alapján
        $officeName = '';
        if ($reservation['user_id'] == 1) {
            $officeName = "GroszUtazas";
        } elseif ($reservation['user_id'] == 2) {
            $officeName = "1000ut";
        } elseif ($reservation['user_id'] == 3) {
            $officeName = "Tensi";
        }
        echo "<td>" . htmlspecialchars($officeName) . "</td>";

        // Úti cél
        echo "<td>" . htmlspecialchars($reservation['destination']) . "</td>";

        // Megjegyzés és kattintható URL
        echo "<td>";
        echo htmlspecialchars($reservation['notes']); // Megjegyzés kiírása
        if (filter_var($reservation['notes'], FILTER_VALIDATE_URL)) {
            echo "<br><a href='" . htmlspecialchars($reservation['notes']) . "' target='_blank'>Megnyitás</a>";
        }
        echo "</td>";

        // Dátumok, napok
        echo '<td class="tc">' . htmlspecialchars($reservation['start_date']) . '</td>';
        echo '<td class="tc">' . htmlspecialchars($reservation['end_date']) . '</td>';
        echo '<td class="tc">' . htmlspecialchars($reservation['days']) . '</td>';

        // Módosítás és törlés linkek
        if ($_SESSION['user_id'] == $reservation['user_id']) {
            echo '<td class="tc"><a href="modositas.php?id=' . (int)$reservation['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>';
            echo '<td class="tc"><a href="torles.php?id=' . (int)$reservation['id'] . '"><span class="delete-icon">&#10060;</span></a></td>';
        } else {
            echo '<td class="tc" colspan="2">Csak saját utat módosíthat!</td>';
        }

        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<p id="note">*A táblázat fejléc celláira kattintva rendezheted utazás, dátum, iroda szerint az adatokat.</p>
</body>
</html>
