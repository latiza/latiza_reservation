<?php


// Kapcsolat létrehozása és ellenőrzése
$conn = new mysqli($servername, $username, $password, $database);

// Kapcsolat ellenőrzése
/*if ($conn->connect_error) {
    die("Sikertelen kapcsolódás az adatbázishoz: " . $conn->connect_error);
} else {
    echo "Sikeresen csatlakozva az adatbázishoz!"; // Ha sikeres a kapcsolat, kiírjuk ezt az üzenetet
}*/

// Kapcsolat bezárása
//$conn->close();


