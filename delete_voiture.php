<?php
session_start();

// Vérification que l'utilisateur est connecté et a le rôle d'administrateur
if (!isset($_SESSION['roles']) || !in_array("ROLE_ADMIN", json_decode($_SESSION['roles'], true))) {
    header("Location: security/login.php");
    exit();
}

$db_username = 'root';
$db_password = '';
$conn = new PDO('mysql:host=localhost;dbname=projet_dg', $db_username, $db_password);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM cars WHERE id = :id");
    $stmt->execute(['id' => $id]);

    header("Location: admin.php");
    exit();
} else {
    header("Location: admin.php");
    exit();
}