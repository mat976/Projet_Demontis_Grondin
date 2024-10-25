<?php
session_start();

// Vérification que l'utilisateur est connecté et a le rôle d'administrateur
if (isset($_SESSION['roles'])) {
    $roles = json_decode($_SESSION['roles'], true);
    if (is_array($roles)) {
        if (!in_array("ROLE_ADMIN", $roles)) {
            // L'utilisateur n'est pas un administrateur, rediriger vers une page d'accueil ou autre
            header("Location: ../index.php");
            exit();
        }
    } else {
        echo "Invalid roles format.";
        session_start();
        
        // Vérification que l'utilisateur est connecté et a le rôle d'administrateur
        if (isset($_SESSION['roles'])) {
            $roles = json_decode($_SESSION['roles'], true);
            if (is_array($roles)) {
                if (!in_array("ROLE_ADMIN", $roles)) {
                    // L'utilisateur n'est pas un administrateur, rediriger vers une page d'accueil ou autre
                    header("Location: index.php");
                    exit();
                }
            } else {
                echo "Invalid roles format.";
                exit();
            }
        } else {
            echo "Unauthorized access.";
            exit();
        }
        
        // Connexion à la base de données
        $db_username = 'root';
        $db_password = '';
        $conn = new PDO('mysql:host=localhost;dbname=projet_dg', $db_username, $db_password);
        
        // Suppression de l'utilisateur
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
            $user_id = $_GET['id'];
            $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute(['id' => $user_id]);
            header("Location: admin.php");
            exit();
        } else {
            echo "Invalid request.";
            exit();
        }
        
        exit();
    }
} else {
    echo "Unauthorized access.";
    exit();
}

// Connexion à la base de données
$db_username = 'root';
$db_password = '';
$conn = new PDO('mysql:host=localhost;dbname=projet_dg', $db_username, $db_password);

// Suppression de l'utilisateur
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    header("Location: admin.php");
    exit();
} else {
    echo "Invalid request.";
    exit();
}
?>