<?php
// Indítsa el a munkamenetet
session_start();

// Távolítsa el az összes munkamenet változót
session_unset();

// Törölje a munkamenetet
session_destroy();

// Átirányítás a bejelentkező oldalra
header("location: login.php");
exit;

