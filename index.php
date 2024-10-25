<?php
// connection a la bdd (pour test)
$dsn = "mysql:host=localhost;dbname=projet_dg;charset=utf8";
$username = "root";
$password = "";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// card logic
$cards_per_page = 8; // 2 rows x 8 columns
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $cards_per_page;

// recheche logic
$search = isset($_GET['search']) ? $_GET['search'] : '';

// prise de donnée sur la bdd
$sql = "SELECT * FROM cars WHERE brand LIKE :search OR model LIKE :search LIMIT :offset, :cards_per_page";
$stmt = $conn->prepare($sql);
$searchParam = '%' . $search . '%';
$stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':cards_per_page', $cards_per_page, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
    <head>
        <title>Boutique</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
    <!-- nav bar-->
    <?php include 'elements/nav_bar.php'; ?>


        <!-- recherche avec logic bdd  -->
        <div class="container my-4">
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2" value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Rechercher</button>
                </div>
            </form>
        </div>

        <!-- Card de voitures -->
        <div class="container">
            <div class="row row-cols-2 row-cols-md-8 g-4">
                <?php if (!empty($result)): ?>
                    <?php foreach ($result as $row): ?>
                        <div class="col">
                            <div class="card h-100">
                                <img src="<?php echo htmlspecialchars($row['images']); ?>" class="card-img-top" alt="Car Image">
                                <div class="card-body row-md">
                                    <h5 class="card-title fs-6-md"><i>Marque: </i><?php echo htmlspecialchars($row['brand']); ?></h5>
                                    <div class="card-text d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                                        <p class="mb-2 mb-sm-0"><i>Modèle : </i><?php echo htmlspecialchars($row['model']); ?></p>
                                        <a class="btn btn-primary btn-sm" href="#">
                                            Voir Plus
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M6 8a.5.5 0 0 0 .5.5h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L12.293 7.5H6.5A.5.5 0 0 0 6 8m-2.5 7a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5"/>
                                            </svg>
                                        </a>
                                    </div>
<!--                                    <div class="card-text d-flex justify-content-between">-->
<!--                                        <p><i>Modèle : </i>--><?php //echo htmlspecialchars($row['model']); ?><!--</p>-->
<!--                                        <a class="btn btn-primary" href="#">-->
<!--                                            Voir Plus-->
<!--                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-right" viewBox="0 0 16 16">-->
<!--                                                <path fill-rule="evenodd" d="M6 8a.5.5 0 0 0 .5.5h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L12.293 7.5H6.5A.5.5 0 0 0 6 8m-2.5 7a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5"/>-->
<!--                                            </svg>-->
<!--                                        </a>-->
<!--                                    </div>-->

                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <span><?php echo htmlspecialchars($row['price']); ?>€</span>
                                    <span><?php
                                        if (htmlspecialchars($row['category']) == '0'){
                                            echo "Neuf";
                                        }
                                        else{
                                            echo "Occasion";
                                        }
                                        ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun modèle existant.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- navigation -->
        <nav class="pt-3" aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=1&search=<?php echo urlencode($search); ?>" aria-label="First">
                        <span aria-hidden="true">&laquo;&laquo;</span>
                    </a>
                </li>
                <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <?php
                // Calcule des pages 
                $total_sql = "SELECT COUNT(*) as count FROM cars WHERE brand LIKE :search OR model LIKE :search";
                $total_stmt = $conn->prepare($total_sql);
                $total_stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
                $total_stmt->execute();
                $total_cars = $total_stmt->fetchColumn();
                $total_pages = ceil($total_cars / $cards_per_page);

                // afichage des pages
                $start_page = max(1, $page - 2);
                $end_page = min($total_pages, $page + 2);

                for ($i = $start_page; $i <= $end_page; $i++) {
                    echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '">';
                    echo '<a class="page-link" href="?page=' . $i . '&search=' . urlencode($search) . '">' . $i . '</a>';
                    echo '</li>';
                }
                ?>

                <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $total_pages; ?>&search=<?php echo urlencode($search); ?>" aria-label="Last">
                        <span aria-hidden="true">&raquo;&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>