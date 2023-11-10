<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Az űrlap által küldött adatok
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Adatbázis kapcsolódás
    $mysqli = require __DIR__ . "/database.php";

    // Ellenőrzés az adatbázisban
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row["password_hash"];

            // Jelszó ellenőrzése
            if (password_verify($password, $hashed_password)) {
                session_start();

                session_regenerate_id();

                $_SESSION["user_id"] = $row["id"];

                header("Location: index.php");
                exit;
            } else {
                $is_invalid = true;
                $error_message = "Hibás jelszó";
            }
        } else {
            $is_invalid = true;
            $error_message = "Nincs ilyen e-mail cím regisztrálva";
        }

        $stmt->close();
    } else {
        die("SQL error:" . $mysqli->error);
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php if ($is_invalid): ?>
        <em><?= htmlspecialchars($error_message) ?></em>
    <?php endif; ?>

    <form method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <button>Login</button>
    </form>
</body>
</html>
