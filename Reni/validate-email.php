<?php
$mysqli = require __DIR__ . "/database.php";

if (isset($_GET["email"])) {
    $email = $_GET["email"];
    
    $sql = sprintf("SELECT * FROM user WHERE email = '%s'",
        $mysqli->real_escape_string($email));

    $result = $mysqli->query($sql);

    $is_available = $result->num_rows === 0;

    header("Content-Type: application/json");
    echo json_encode(["available" => $is_available]);
} else {
    echo json_encode(["error" => "Email parameter is missing"]);
}
?>
