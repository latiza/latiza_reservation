<?php
// Időzóna és "ma" beállítása – fontos a hónapszűréshez és SQL-hez
date_default_timezone_set('Europe/Budapest');
$today = date('Y-m-d');
$monthStart = date('Y-m-01'); // aktuális hónap első napja

// "Előző időszak" mód kapcsoló URL-ből (?prev=1)
// Lazább ellenőrzés: ha valami string/int konverzió miatt eltér, akkor is működjön
$includePast = isset($_GET['prev']) && $_GET['prev'] == '1';

// Adatbázis kapcsolódás
require 'connect.php';

// Naptár megjelenítési tartomány
// - Kezdőév: ha prev=1, akkor fixen 2025-től (vagy ameddig akarod)
// - Ha nincs prev: az aktuális évtől indul
$startYear = $includePast ? 2025 : (int)date('Y');

// Vége: maradhat fixen 2026, vagy ha szeretnéd automatikusra, akkor pl. aktuális év + 1
$endYear = 2026;

// Aktuális hónaptól indulunk, ha nincs prev
$startMonth = (int)date('n');

// SQL alsó határ
// - prev=1: ne vágjunk le semmit → legyen nagyon régi dátum (vagy akár elhagyhatnánk a WHERE-t)
// - különben: aktuális hónap eleje
$calendarLowerBound = $includePast ? '0000-01-01' : $monthStart;

// Foglalások lekérése
$sql = "SELECT * FROM reservations WHERE end_date >= '{$calendarLowerBound}'";
$result = $conn->query($sql);

// Foglalások tömbbe
$reservations = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
}
$conn->close();

// Segédfüggvény: van-e foglalás az adott napon (és színt + útnevet ad vissza)
function reservationInfoForDate($date, $reservations) {
    foreach ($reservations as $r) {
        if ($date >= $r['start_date'] && $date <= $r['end_date']) {
            $class = '';
            if ((int)$r['user_id'] === 1) $class = 'highlight-orange';
            elseif ((int)$r['user_id'] === 2) $class = 'highlight-red';
            elseif ((int)$r['user_id'] === 3) $class = 'highlight-blue';
            return [$class, $r['destination']];
        }
    }
    return ['', ''];
}

// Linkek biztosan a jelenlegi fájlra mutassanak (ne legyen gond mappával/átirányítással)
$self = htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/calendar.css">
<title>Foglalt időpontok</title>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const calendar = document.getElementById('calendar');
    const snackbar = document.getElementById('snackbar');

    function showSnack(text) {
        if (!text) return;
        snackbar.textContent = text;
        snackbar.classList.add('show');
        setTimeout(() => snackbar.classList.remove('show'), 2700);
    }

    calendar.addEventListener('click', (e) => {
        const cell = e.target.closest('td[data-destination]');
        if (!cell) return;
        const dest = cell.getAttribute('data-destination') || '';
        if (dest.trim().length) showSnack(dest);
    });

    const cells = calendar.querySelectorAll('td[data-destination]');
    cells.forEach(cell => {
        const dest = cell.getAttribute('data-destination');
        if (dest) cell.title = dest;
    });
});
</script>
</head>
<body>
<?php include 'nav.php'; ?>
<h2>2025–2026. évi naptár</h2>

<div id="calendar">

  <div class="toolbar" style="margin: 10px 0 20px; display:flex; gap:10px; flex-wrap:wrap;">
    <a href="<?= $self ?>?prev=1" class="btn">
      Előző időszak betöltése
    </a>

    <?php if ($includePast) : ?>
      <a href="<?= $self ?>" class="btn-outline">
        Csak az aktuális időszak
      </a>
    <?php endif; ?>
  </div>

  <table>
    <tr>
      <th>GroszUtazas</th><td class="orange"></td><td></td>
      <th>1000út</th><td class="red"></td>
      <th>Nem foglalható időpont</th><td class="blue"></td>
    </tr>
  </table>

<?php
// Hónapok kirajzolása:
// - prev=1: 2025 januártól induljon
// - különben: az aktuális hónaptól induljon az aktuális évben
for ($year = $startYear; $year <= $endYear; $year++) {

    $mStart = ($year === (int)date('Y'))
        ? ($includePast ? 1 : $startMonth)
        : 1;

    for ($month = $mStart; $month <= 12; $month++) {

        $firstOfMonth = date('Y-m-01', mktime(0,0,0,$month,1,$year));
        $lastOfMonth  = date('Y-m-t',  mktime(0,0,0,$month,1,$year));

        // csak akkor ugrunk, ha NINCS prev mód
        if (!$includePast && $lastOfMonth < $today) continue;

        $monthName   = strftime('%B', mktime(0,0,0,$month,1,$year));
        $daysInMonth = (int)date('t', mktime(0,0,0,$month,1,$year));

        echo "<div class='month'>";
        echo "<h3>" . htmlspecialchars($monthName) . " $year</h3>";
        echo "<table>";
        echo "<tr><th>H</th><th>K</th><th>Sz</th><th>Cs</th><th>P</th><th>Sz</th><th>V</th></tr>";
        echo "<tr>";

        $dayOfWeek = (int)date('N', mktime(0,0,0,$month,1,$year));
        for ($i = 1; $i < $dayOfWeek; $i++) echo "<td></td>";

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = date('Y-m-d', mktime(0,0,0,$month,$day,$year));
            [$highlightClass, $destination] = reservationInfoForDate($currentDate, $reservations);

            $dataAttr = $destination !== '' ? " data-destination='".htmlspecialchars($destination, ENT_QUOTES)."'" : '';
            echo "<td class='".htmlspecialchars($highlightClass)."'{$dataAttr}>$day</td>";

            if ((int)date('N', mktime(0,0,0,$month,$day,$year)) === 7) {
                echo "</tr><tr>";
            }
        }

        echo "</tr>";
        echo "</table>";
        echo "</div>";
    }
}
?>

</div>

<div id="snackbar" aria-live="polite" role="status"></div>

</body>
</html>
