<?php
session_start();

// Ellenőrizzük, hogy be van-e lépve a felhasználó
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

require 'connect.php';

// Üzenetek inicializálása
$message = '';

// Űrlap elküldése
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $destination = $_POST['destination'];
    $notes = $_POST['notes'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Napok számának automatikus kiszámítása
    $startDateTime = new DateTime($start_date);
    $endDateTime = new DateTime($end_date);
    $days = $startDateTime->diff($endDateTime)->days + 1; // +1, hogy a kezdő és végdátum is beleszámítson

    // Felhasználó irodájának lekérdezése az adatbázisból
    $user_id = $_SESSION['user_id'];
    $sql_office = "SELECT user_name FROM travelusers WHERE id = '$user_id'";
    $result_office = $conn->query($sql_office);

    if ($result_office->num_rows > 0) {
        $row_office = $result_office->fetch_assoc();
        $user_name = $row_office['user_name'];
    }

    // Ellenőrizze, hogy az új időpont nem fed-e le már meglévő időpontot
    $sql = "SELECT * FROM reservations WHERE ((start_date <= '$start_date' AND end_date >= '$start_date') OR (start_date <= '$end_date' AND end_date >= '$end_date'))";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $message = "Az új időpont átfedésbe került egy már meglévő időponttal. Kérlek, válassz más időpontot.";
    } else {
        // Új út hozzáadása az adatbázishoz
        $sql_insert = "INSERT INTO reservations (user_id, destination, notes, start_date, end_date, days) VALUES ('$user_id', '$destination', '$notes', '$start_date', '$end_date', '$days')";
        if ($conn->query($sql_insert) === TRUE) {
            $message = "Az út sikeresen fel lett véve.";
            header("Location: table.php");
            exit;
        } else {
            $message = "Hiba történt az út felvitele közben: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link rel="stylesheet" href="css/reservationstyle.css">

    <title>Út felvitele</title>
 
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const daysInput = document.getElementById('days');

            const updateDays = () => {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);
                if (!isNaN(startDate) && !isNaN(endDate) && startDate <= endDate) {
                    const diffTime = Math.abs(endDate - startDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                    daysInput.value = diffDays;
                } else {
                    daysInput.value = '';
                }
            };

            startDateInput.addEventListener('change', updateDays);
            endDateInput.addEventListener('change', updateDays);
        });
    </script>
</head>
<body>
<div class="container">
 <?php include 'nav.php'; ?>
    <div class="form-content">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Út felvitele</h2>
        <p><?php echo $message; ?></p>
        <label for="destination">Úti cél:</label>
        <input type="text" id="destination" name="destination" required placeholder="Út neve">
        <label for="start_date">Kezdő dátum:</label>
        <input type="date" id="start_date" name="start_date" required>
        <label for="end_date">Vég dátum:</label>
        <input type="date" id="end_date" name="end_date" required>
        <label for="notes">Megjegyzések:</label>
        <textarea id="notes" name="notes" placeholder="Út webcíme..."></textarea>
        <label for="days">Napok száma:</label>
        <input type="number" id="days" name="days" readonly>
        <input type="submit" value="Út felvétele">
    </form>
    </div>
</div>
</body>
</html>
