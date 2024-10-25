<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="path/to/icon.png" alt="Icon" width="30" height="24">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="home.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Magasin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="about.php">À propos</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php
                // Assurez-vous d'avoir démarré la session au début de votre fichier
                if (!isset($_SESSION)) {
                    session_start();
                }

                if (isset($_SESSION['user_id'])) {
                    // L'utilisateur est connecté, afficher le bouton de déconnexion
                    ?>
                    <a href="security/logout.php" class="btn btn-outline-danger">Déconnexion</a>
                    <?php
                } else {
                    // L'utilisateur n'est pas connecté, afficher les boutons de connexion et d'inscription
                    ?>
                    <a href="security/login.php" class="btn btn-outline-success me-2">Login</a>
                    <a href="security/register.php" class="btn btn-outline-primary">Sign In</a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</nav>