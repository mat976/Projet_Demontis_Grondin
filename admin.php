<?php
session_start();
// Vérification que l'utilisateur est connecté et a le rôle d'administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['roles'] !== 'ROLE_ADMIN') {
    header("Location: security/login.php");
    exit();
}

// Connexion à la base de données
$db_username = 'root';
$db_password = '';
$conn = new PDO('mysql:host=localhost;dbname=projet_dg', $db_username, $db_password);

// Fonctions pour récupérer les données
function getVoitures($conn) {
    $stmt = $conn->query("SELECT * FROM cars");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUsers($conn) {
    $stmt = $conn->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$voitures = getVoitures($conn);
$users = getUsers($conn);
?>

<!doctype html>
<html lang="fr">
<head>
    <title>Administration</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>
<body>
    <!-- nav bar-->
    <?php include 'elements/nav_bar.php'; ?>

    <div class="container mt-4">
        <h1 class="mb-4">Panneau d'administration</h1>

        <!-- Section Gestion des Voitures -->
        <h2>Gestion des Voitures</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voitures as $voiture): ?>
                <tr>
                    <td><?= htmlspecialchars($voiture['id']) ?></td>
                    <td><?= htmlspecialchars($voiture['brand']) ?></td>
                    <td><?= htmlspecialchars($voiture['model']) ?></td>
                    <td>
                        <a href="edit_voiture.php?id=<?= $voiture['id'] ?>" class="btn btn-sm btn-primary">Modifier</a>
                        <a href="delete_voiture.php?id=<?= $voiture['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette voiture ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_voiture.php" class="btn btn-success mb-4">Ajouter une voiture</a>

        <!-- Section Gestion des Utilisateurs -->
        <h2>Gestion des Utilisateurs</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pseudo</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['pseudo']) ?></td>
                    <td><?= htmlspecialchars($user['firstname']) ?></td>
                    <td><?= htmlspecialchars($user['lastname']) ?></td>
                    <td><?= htmlspecialchars($user['roles']) ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-primary">Modifier</a>
                        <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_user.php" class="btn btn-success">Ajouter un utilisateur</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>