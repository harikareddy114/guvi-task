<?php
session_start();

$servername = "localhost";
$username = "root";
$db_password = "Harika@114";
$dbname = "guvi";

$db = new mysqli($servername, $username, $db_password, $dbname);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    $profileData = ['success' => false];
    echo json_encode($profileData);

    $db->close();
    exit();
}

$user_id = $_SESSION['user_id'];

$selectQuery = "SELECT name, email, number, dob FROM users WHERE id = ?";
$stmt = $db->prepare($selectQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $dob = new DateTime($row['dob']);
    $currentDate = new DateTime();
    $age = $currentDate->diff($dob)->y;
    $profileData = [
        'success' => true,
        'name' => $row['name'],
        'email' => $row['email'],
        'number' => $row['number'],
        'dob' => $row['dob'],
        'age' => $age,
    ];

    echo json_encode($profileData);
} else {
    $profileData = ['success' => false];
    echo json_encode($profileData);
}

$stmt->close();
$db->close();
?>
