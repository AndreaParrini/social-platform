<?php

require __DIR__ . '/./DB.php';

$connection = DB::Connect();

if (empty($_POST['orderBy'])) {
    $sql =
        'SELECT `users`.*, COUNT(`likes`.`post_id`) AS `total_like`
         FROM `users`
         JOIN `posts` ON `posts`.`user_id` = `users`.`id`
         JOIN `likes` ON `likes`.`post_id` = `posts`.`id`
         GROUP BY `users`.`id`
         ORDER BY `total_like`';
    $result = $connection->query($sql);
}

if (!empty($_POST['orderBy'])) {
    $sql =
        'SELECT `users`.*, COUNT(`likes`.`post_id`) AS `total_like`
         FROM `users`
         JOIN `posts` ON `posts`.`user_id` = `users`.`id`
         JOIN `likes` ON `likes`.`post_id` = `posts`.`id`
         GROUP BY `users`.`id`
         ORDER BY `total_like`' . $_POST['orderBy'];
    $result = $connection->query($sql);
}

DB::Close($connection);

?>

<!doctype html>
<html lang="en">

<head>
    <title>Social Platform</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Font-Awesome v6.5.2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-secondary">
    <header>
        <nav class="navbar bg-info p-3 mb-3">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <i class="fa-solid fa-camera fa-2xl" style="color: #000000;"></i>
                </a>
                <h2 class="fst-italic text-uppercase">Social Platform</h2>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <h3 class="text-info text-center text-uppercase fst-italic mt-3 mb-3">Lista Utenti con il totale Like ricevuti</h3>
            <form method="post" action="#" class="text-center">
                <div>
                    Ordina in base ai Like :
                </div>
                <div class="d-flex gap-3 justify-content-center mt-3 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="ASC" name="orderBy" id="orderByAsc" />
                        <label class="form-check-label" for="orderByAsc"> Crescente </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="DESC" name="orderBy" id="orderByDesc" />
                        <label class="form-check-label" for="OrderByDesc"> Decrescente </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-info mb-3">
                    Ordina
                </button>
            </form>


            <div class="row">
                <?php while ($rows = $result->fetch_assoc()) :
                    [
                        'id' => $userID,
                        'username' => $username,
                        'email' => $email,
                        'birthdate' => $birthdate,
                        'phone' => $phone,
                        'total_like' => $total_like
                    ] = $rows;
                ?>
                    <div class="col-xs-12 col-md-6 col-xl-4 mb-3">
                        <div class="card mb-3 h-100 border-info bg-info-subtle" style="max-width: 540px;">
                            <div class="row g-0 h-100">
                                <div class="col-4">
                                    <img src="https://picsum.photos/id/<?= $userID ?>/200/300" class="img-fluid rounded-start h-100 w-100" alt="Immagine profile utente">
                                </div>
                                <div class="col-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $username; ?></h5>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item p-0 pt-2 pb-2 border-dark bg-info-subtle"><?= $email; ?></li>
                                            <!-- Uso strtotime() per convertite la stringa della data in timestamp e poi con date() indico il formato della data che volgio ottonere -->
                                            <li class="list-group-item p-0 pt-2 pb-2 border-dark bg-info-subtle"><?= date('d-m-Y', strtotime($birthdate)); ?></li>
                                            <li class="list-group-item p-0 pt-2 pb-2 border-dark bg-info-subtle">Cellulare : <?= $phone; ?></li>
                                            <li class="list-group-item p-0 pt-2 pb-2 border-dark bg-info-subtle">
                                                <p class="card-text mt-2"><small class="text-secondary">Total like : <?= $total_like; ?></small></p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
    <footer class="bg-info p-4">
        <div class="container">
            <div class="d-flex justify-content-between">
                <div>
                    Create by Booleaner Andrea Parrini on 2024 <i class="fa-regular fa-copyright" style="color: #000000;"></i>
                </div>
                <div>
                    <a href="#"><i class="fa-brands fa-square-instagram fa-2xl" style="color: #000000;"></i></a>
                    <a href="#"><i class="fa-brands fa-square-x-twitter fa-2xl" style="color: #000000;"></i></a>
                    <a href="#"><i class="fa-brands fa-square-facebook fa-2xl" style="color: #000000;"></i></i></a>
                </div>
            </div>
        </div>

    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>