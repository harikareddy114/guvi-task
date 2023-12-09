<?php

$servername = "localhost";
$username = "root";
$db_password = "Harika@114";
$dbname = "guvi";

$db = new mysqli($servername, $username, $db_password, $dbname);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
} else {
    echo "Connected successfully\n";
}

$createTableQuery = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    number VARCHAR(15) NOT NULL,
    dob DATE NOT NULL,
    password VARCHAR(255) NOT NULL
)";

if ($db->query($createTableQuery) === TRUE) {
    echo "Table 'users' created successfully\n";
} else {
    echo "Error creating table: " . $db->error . "\n";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $dob = $_POST['dob'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $db->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email already exists in the database. Please choose a different email.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO users (name, email, number, dob, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($insertQuery);
        $stmt->bind_param("sssss", $name, $email, $number, $dob, $hashedPassword);

        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error in creating " . $insertQuery . "<br>" . $stmt->error;
        }
    }

    $stmt->close();
    $db->close();
}

?>
