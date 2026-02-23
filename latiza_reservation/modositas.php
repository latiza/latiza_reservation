<?php
require('connect.php');
session_start();

// Ellenőrizzük, hogy be van-e lépve a felhasználó
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

require 'connect.php';

// Üzenetek inicializálása
$message = '';

// Ellenőrizd, hogy az id paraméter meg van-e adva
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Ellenőrizd, hogy a bejelentkezett felhasználó azonos-e az út tulajdonosával
    $sql_check_owner = "SELECT user_id FROM reservations WHERE id = $id";
    $result_check_owner = $conn->query($sql_check_owner);

    if ($result_check_owner->num_rows > 0) {
        $row_check_owner = $result_check_owner->fetch_assoc();

        if ($_SESSION['user_id'] != $row_check_owner['user_id'] && $_SESSION['user_id'] != 3) {
            // Ha nem azonos, akkor visszairányíthatod a felhasználót például a table.php oldalra
            header("Location: table.php");
            exit;
        }
    } else {
        // Ha nem található ilyen id-jú foglalás, kezeljük a hibát
        echo "Nincs ilyen id-jú foglalás.";
        exit;
    }

} else {
    // Ha az id paraméter nincs megadva, kezeljük a hibát
    echo "Hiányzó id paraméter.";
    exit;
}

// Üzenetek inicializálása
$message = '';

// Ellenőrizzük, hogy az id paraméter meg van-e adva
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Lekérdezés az adott id-jú foglalásról
    $sql = "SELECT * FROM reservations WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Foglalás adatainak beolvasása
        $reservation = $result->fetch_assoc();

        // Űrlap elküldése
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $destination = $_POST['destination'];
            $notes = $_POST['notes'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $days = $_POST['days'];

            // Ellenőrizze, hogy az új időpont nem fed-e le már meglévő időpontot
            $sql_overlap = "SELECT * FROM reservations WHERE id != $id AND ((start_date <= '$start_date' AND end_date >= '$start_date') OR (start_date <= '$end_date' AND end_date >= '$end_date'))";
            $result_overlap = $conn->query($sql_overlap);

            if ($result_overlap->num_rows > 0) {
                $message = "Az új időpont átfedésbe került egy már meglévő időponttal. Kérlek, válassz más időpontot.";
            } else {
                // Foglalás frissítése az adatbázisban
                $sql_update = "UPDATE reservations SET destination = '$destination', notes = '$notes', start_date = '$start_date', end_date = '$end_date', days = '$days' WHERE id = $id";
                if ($conn->query($sql_update) === TRUE) {
                    $message = "Az út sikeresen módosítva lett.";
                    header("Location: table.php");
                } else {
                    $message = "Hiba történt az út módosítása közben: " . $conn->error;
                }
            }
        }
    } else {
        // Ha nincs ilyen id-jú foglalás, kezeljük a hibát
        echo "Nincs ilyen id-jú foglalás.";
        exit;
    }
} else {
    // Ha az id paraméter nincs megadva, kezeljük a hibát
    echo "Hiányzó id paraméter.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reservationstyle.css">

    <title>Út módosítása</title>
</head>

<body>
    <div class="container">
    <?php include 'nav.php'; ?>
        <div class="form-content">
            <p><?php echo $message; ?></p>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>">
                <label for="destination">Úti cél módosítása:</label>
                <input type="text" id="destination" name="destination"
                    value="<?php echo $reservation['destination']; ?>" required>
                <label for="start_date">Kezdő dátum módosítása:</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo $reservation['start_date']; ?>"
                    required>
                <label for="end_date">Vég dátum módosítása:</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo $reservation['end_date']; ?>"
                    required>
                <label for="notes">Megjegyzések módosítása:</label>
                <textarea id="notes" name="notes"><?php echo $reservation['notes']; ?></textarea>
                <label for="days">Napok száma:</label>
                <input type="number" id="days" name="days" value="<?php echo $reservation['days']; ?>" required>
                <input type="submit" value="Módosítások mentése">
            </form>
        </div>
    </div>
</body>

</html>