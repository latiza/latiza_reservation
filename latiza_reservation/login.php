<?php
session_start();

require'connect.php';
// Kapcsolat létrehozása
$conn = new mysqli($servername, $username, $password, $database);

// Kapcsolat ellenőrzése
if ($conn->connect_error) {
    die("Sikertelen kapcsolódás az adatbázishoz: " . $conn->connect_error);
}

// Ha POST kérést kapunk, ellenőrizzük a felhasználó által megadott adatokat
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    // Előkészített utasítás
    $stmt = $conn->prepare("SELECT id, user_name FROM travelusers WHERE user_name = ? AND password = ?");
    $stmt->bind_param("ss", $user_name, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) { // Sikeres belépés
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        header("Location: table.php");
        exit;
    } else { // Sikertelen belépés
        $error = "Hibás felhasználónév vagy jelszó!";
    }
}
// Kapcsolat bezárása
//$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belépés</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css"> <!-- CSS stíluslap hivatkozás -->
</head>
<body>
<?php include 'nav.php'; ?>
<div class="container">
 


<div class="login-container">

    <h2>Belépés</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="user_name">Felhasználónév:</label>
            <input type="text" id="user_name" name="user_name" required>
        </div>
        <div class="form-group">
            <label for="password">Jelszó:</label>
            <input type="password" id="password" name="password" required>
            <span id="togglePassword">👁️</span>
        </div>
        <button type="submit">Belépés</button>
    </form>
    <?php if(isset($error)) { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>
</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    });
</script>
</body>
</html>
