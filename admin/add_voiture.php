<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérification que l'utilisateur est connecté et a le rôle d'administrateur
if (!isset($_SESSION['roles']) || !in_array("ROLE_ADMIN", json_decode($_SESSION['roles'], true))) {
    header("Location: ../security/login.php");
    exit();
}

$db_username = 'root';
$db_password = '';
$conn = new PDO('mysql:host=localhost;dbname=projet_dg', $db_username, $db_password);

$error_message = '';

$upload_dir = __DIR__ . '/images/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}
if (!is_writable($upload_dir)) {
    $error_message = "Le répertoire d'upload n'est pas accessible en écriture.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['brand']) && !empty($_POST['model']) && !empty($_POST['price']) && !empty($_POST['category'])) {
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        // perparation de l'envoie de l'image
        $target_dir = $upload_dir;
        $uploadOk = 1;
        $image_file = null;

        if(isset($_FILES["images"]) && $_FILES["images"]["error"] == 0) {
            $target_file = $target_dir . basename($_FILES["images"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // virifier si c'est une image
            $check = getimagesize($_FILES["images"]["tmp_name"]);
            if($check !== false) {
                // Check file size
                if ($_FILES["images"]["size"] > 500000) {
                    $error_message = "Désolé, votre fichier est trop volumineux.";
                    $uploadOk = 0;
                }
            } else {
                $error_message = "Le fichier n'est pas une image.";
                $uploadOk = 0;
            }

            // check si le fichier existe ou non
            if (file_exists($target_file)) {
                $error_message = "Désolé, le fichier existe déjà.";
                $uploadOk = 0;
            }

            // autorise les formats d'images suivants
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $error_message = "Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
                $uploadOk = 0;
            }

            // si tout est bon envoie l'image et la base de données
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["images"]["tmp_name"], $target_file)) {
                    $image_file = basename($target_file);
                } else {
                    $error_message = "Désolé, une erreur s'est produite lors de l'upload du fichier. Error: " . error_get_last()['message'];
                    $uploadOk = 0;
                }
            }
        } else {
            $error_message = "Veuillez sélectionner une image.";
            $uploadOk = 0;
        }

        // si pas d'erreur envoie la voiture dans la base de données
        if ($uploadOk == 1) {
            $stmt = $conn->prepare("INSERT INTO cars (brand, model, price, category, images) VALUES (:brand, :model, :price, :category, :images)");
            if ($stmt->execute([
                'brand' => $brand, 
                'model' => $model, 
                'price' => $price, 
                'category' => $category, 
                'images' => "images/".$image_file
            ])) {
                header("Location: admin.php");
                exit();
            } else {
                $error_message = "Une erreur s'est produite lors de l'ajout de la voiture dans la base de données.";
            }
        }
    } else {
        $error_message = 'Veuillez remplir tous les champs.';
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <title>Ajouter une voiture</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>
<body>
    <div class="container mt-4">
        <h1>Ajouter une voiture</h1>
        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="brand" class="form-label">Marque</label>
                <input type="text" class="form-control" id="brand" name="brand" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Modèle</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Prix</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Catégorie</label>
                <input type="text" class="form-control" id="category" name="category" required>
            </div>
            <div class="mb-3">
                <label for="images" class="form-label">Image</label>
                <input type="file" class="form-control" id="images" name="images" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
            <a href="admin.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>