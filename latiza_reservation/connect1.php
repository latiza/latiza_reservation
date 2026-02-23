<?php
$servername = "a056um.forpsi.com"; // Az adatbázis szerverének neve (általában "localhost")
$username = "b26544"; // Az adatbázis felhasználóneve (alapértelmezetten "root" XAMPP esetén)
$password = "tizacska"; // Az adatbázis jelszava (alapértelmezetten üres XAMPP esetén)
$database = "b26544"; // Az adatbázis neve, amit létrehoztál

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

