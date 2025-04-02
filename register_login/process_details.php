<?php
session_start();
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: register_login/login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $emergency_name = mysqli_real_escape_string($conn, $_POST['emergency_name']);
    $emergency_phone = mysqli_real_escape_string($conn, $_POST['emergency_phone']);
    $query = "INSERT INTO user_details (user_id, fullname, dob, gender, phone, address, emergency_name, emergency_phone) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssssss", $user_id, $fullname, $dob, $gender, $phone, $address, $emergency_name, $emergency_phone);
    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to save details!";
        header("Location: user_details.php");
        exit();
    }
}
?>