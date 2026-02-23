<?php
session_start();

// Ellenőrizzük, hogy be van-e lépve a felhasználó
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

require'connect.php';

// Üzenetek inicializálása
$message = '';

// Ellenőrizzük, hogy az id paraméter meg van-e adva
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

    // Törlés végrehajtása
    $sql_delete = "DELETE FROM reservations WHERE id = $id";
    if ($conn->query($sql_delete) === TRUE) {
        $message = "Az út sikeresen törölve lett.";
    } else {
        $message = "Hiba történt az út törlése közben: " . $conn->error;
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
    <link rel="stylesheet" href="css/delete.css">
    <title>Út törlése</title>
</head>
<body>
<?php include 'nav.php'; ?>
<h2>Út törlése</h2>
<p><?php echo $message; ?></p>
<a href="table.php">Vissza a táblázathoz</a>
</body>
</html>
