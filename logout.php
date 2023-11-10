<?php
session_start();

// Ellenőrzés
if (isset($_SESSION["user_id"])) {

    session_destroy();
}

// Visszairányítás a kezdőoldalra
header("Location: index.php");
exit;
?>
