<!doctype html>
<html lang="fr">
<head>
    <title>Inscription</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!-- Import de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
</head>

<!-- Page modifiée pour l'inscription -->
<body>

<?php
$db_username = 'root';
$db_password = '';
$conn = new PDO( 'mysql:host=localhost;dbname=projet_dg', $db_username, $db_password );
if(!$conn){
    die("Fatal Error: Connection Failed!");
}
?>
<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-3 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">

                                <div class="text-center">
                                    <h4 class="mt-1 mb-5 pb-1">Nous sommes Projet_dg</h4>
                                </div>

                                <form method="post">
                                    <p>Créez votre compte :</p>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" id="pseudo" name="pseudo" class="form-control"
                                            placeholder="Pseudo" required />
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" id="firstname" name="firstname" class="form-control"
                                            placeholder="Prénom" required />
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" id="lastname" name="lastname" class="form-control"
                                            placeholder="Nom" required />
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="password" id="pass" name="pass" class="form-control"
                                        placeholder="Mot de Passe" required />
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="password" id="confirm_pass" name="confirm_pass" class="form-control"
                                        placeholder="Confirmer le mot de passe" required />
                                    </div>

                                    <div class="text-center pt-1 mb-2 pb-1">
                                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">
                                            S'inscrire
                                        </button>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center pb-2">
                                        <p class="mb-0 me-2">Déjà inscrit(e)?</p>
                                        <a href="login.php" class="btn btn-outline-danger">Se connecter</a>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                            <div class="text-black px-3 py-4 p-md-5 mx-md-4">
                                <div class="d-flex justify-content-center">
                                    <img class="rounded" src="../images/pythongreen.png"
                                         style="width: 200px;" alt="logo">
                                </div>
                                <h4 class="mb-4 mt-4">Rejoignez-nous dès aujourd'hui</h4>
                                <p class="small mb-0">Créez votre compte pour accéder à toutes nos fonctionnalités et offres exclusives. Nous sommes ravis de vous accueillir dans notre communauté !</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
<!-- Scripts -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = $_POST['pseudo'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $pass = $_POST['pass'];
    $confirm_pass = $_POST['confirm_pass'];

    if ($pass !== $confirm_pass) {
        echo "<script>alert('Les mots de passe ne correspondent pas.');</script>";
    } else {
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        $default_role = json_encode(["ROLE_USER"]); // Rôle par défaut pour un nouvel utilisateur
        
        $stmt = $conn->prepare("INSERT INTO users (pseudo, firstname, lastname, password, roles) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$pseudo, $firstname, $lastname, $hashed_password, $default_role])) {
            echo "<script>alert('Inscription réussie ! Vous allez être redirigé vers la page de connexion.'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Erreur lors de l\'inscription. Veuillez réessayer.');</script>";
        }
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</html>