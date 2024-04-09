<?php

/* require file DB.php  */
require __DIR__ . '/./DB.php';

/* Uso la funzione statica Connect() dell'oggetto DB, per connetterci al DB e associo il risultato alla variabile $connection */
$connection = DB::Connect();

/* controllo se la variabile $_POST[orderBy] è vuota */
if (empty($_POST['orderBy'])) {

    /* Associo alla variabile $sql la query da fare al database */
    $sql =
        'SELECT `users`.*, COUNT(`likes`.`post_id`) AS `total_like`
         FROM `users`
         JOIN `posts` ON `posts`.`user_id` = `users`.`id`
         JOIN `likes` ON `likes`.`post_id` = `posts`.`id`
         GROUP BY `users`.`id`
         ORDER BY `total_like`';

    /* Uso la funzione query() per recuperare tutti i risultati e li associo alla varibile $result  */
    $result = $connection->query($sql);
}

/* contorllo se la la variabile $_POST[orderBy] non è vuota */
if (!empty($_POST['orderBy'])) {

    /* preparo la query da fare nel caso la varibile non è vuota concatenando la variabile alla query. */
    $sql =
        'SELECT `users`.*, COUNT(`likes`.`post_id`) AS `total_like`
         FROM `users`
         JOIN `posts` ON `posts`.`user_id` = `users`.`id`
         JOIN `likes` ON `likes`.`post_id` = `posts`.`id`
         GROUP BY `users`.`id`
         ORDER BY `total_like`' . $_POST['orderBy'];

    /* Uso la funzione query() per recuperare tutti i risultati e li associo alla varibile $result  */
    $result = $connection->query($sql);
}

/* Chiudo la connesione con il Database */
DB::Close($connection);

?>
<!-- /* require file head.php  */ -->
<?php require_once __DIR__ . '/head.php' ?>

<!-- /* require file header.php  */ -->
<?php require_once __DIR__ . '/header.php' ?>

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

            <!-- con l'iterazione while ciclo all'interno dei risulati ottenuti, con la funzione fetch_assoc() attribuisco a $rows ad ogni iterazione un valore diverso 
            fino a che attribuisco un valore il ciclo while continua, quando non ci sono più dati si interrompe -->
            <?php while ($rows = $result->fetch_assoc()) :

                /* effettuo il destructring dell'oggetto attribuito alla varibile $rows (i risultati della query.) */
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
                                        <!-- Uso strtotime() per convertite la stringa della data in timestamp e poi con date() indico il formato della data che voglio ottenere -->
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

<!-- /* require file footer.php  */ -->
<?php require_once __DIR__ . '/footer.php' ?>