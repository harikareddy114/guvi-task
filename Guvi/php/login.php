<?php

$servername = "localhost";
$username = "root";
$db_password = "Harika@114";
$dbname = "guvi";

$db = new mysqli($servername, $username, $db_password, $dbname);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

echo "Login.php is working!";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $checkUserQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $db->prepare($checkUserQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $hashedPassword = $user['password'];

        echo "Entered password: " . $password . "<br>";
        echo "Hashed password from database: " . $hashedPassword . "<br>";

        if (password_verify($password, $hashedPassword)) {
            header("Location: /guvi/profile.html");
            exit();
        } else {
            echo "Invalid email or password";
        }
    } else {
        echo "Invalid email or password";
    }

    $stmt->close();
}

$db->close();
?>
