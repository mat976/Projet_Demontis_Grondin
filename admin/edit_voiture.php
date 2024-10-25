<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['roles']) || !in_array("ROLE_ADMIN", json_decode($_SESSION['roles'], true))) {
    header("Location: ../security/login.php");
    exit();
}

$db_username = 'root';
$db_password = '';
$conn = new PDO('mysql:host=localhost;dbname=projet_dg', $db_username, $db_password);

$error_message = '';
$success_message = '';

if (isset($_GET['id'])) {
    $car_id = $_GET['id'];

    // Fetch car details
    $stmt = $conn->prepare("SELECT * FROM cars WHERE id = :id");
    $stmt->execute(['id' => $car_id]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$car) {
        $error_message = "Voiture non trouvée.";
    }
} else {
    header("Location: admin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['brand']) && !empty($_POST['model']) && !empty($_POST['price']) && !empty($_POST['category'])) {
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        $stmt = $conn->prepare("UPDATE cars SET brand = :brand, model = :model, price = :price, category = :category WHERE id = :id");
        if ($stmt->execute([
            'brand' => $brand,
            'model' => $model,
            'price' => $price,
            'category' => $category,
            'id' => $car_id
        ])) {
            header("Location: admin.php");
            exit();
        } else {
            $error_message = "Une erreur s'est produite lors de la mise à jour de la voiture.";
        }
    } else {
        $error_message = 'Veuillez remplir tous les champs.';
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <title>Modifier une voiture</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>
<body>
    <div class="container mt-4">
        <h1>Modifier une voiture</h1>
        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="brand" class="form-label">Marque</label>
                <input type="text" class="form-control" id="brand" name="brand" value="<?php echo htmlspecialchars($car['brand']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Modèle</label>
                <input type="text" class="form-control" id="model" name="model" value="<?php echo htmlspecialchars($car['model']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Prix</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($car['price']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Catégorie</label>
                <input type="text" class="form-control" id="category" name="category" value="<?php echo htmlspecialchars($car['category']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="admin.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>