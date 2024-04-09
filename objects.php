<?php
/* require file Media.php  */
require __DIR__ . '/Models/Media.php';

/* require file Post.php  */
require __DIR__ . '/Models/Post.php';

/* require file DB.php  */
require __DIR__ . '/DB.php';

/* Uso la funzione statica Connect() dell'oggetto DB, per connetterci al DB e associo il risultato alla variabile $connection */
$connection = DB::Connect();

/* Associo alla variabile $sqlAllMedias la query da fare al database per recuperare tutti i media */
$sqlAllMedias = 'SELECT * FROM `medias` WHERE `id` < 31';

/* Uso la funzione query() per recuperare tutti i risultati e li associo alla varibile $allMedias  */
$allMedias = $connection->query($sqlAllMedias);

/* inizializzo la variabile medias, alla quale poi associerò tutti i media */
$medias = [];

/* con l'iterazione while ciclo all'interno dei risulati ottenuti, con la funzione fetch_assoc() attribuisco a $row ad ogni iterazione un valore diverso 
fino a che attribuisco un valore il ciclo while continua, quando non ci sono più dati si interrompe */

while ($row = $allMedias->fetch_assoc()) {

    /* effettuo il destructring dell'oggetto attribuito alla varibile $row (i risultati della query.) */
    [
        'id' => $id,
        'user_id' => $user,
        'type' => $type,
        'path' => $path
    ] = $row;


    if ($type === 'video') {
        /* se il type è un video aggiungo all'array $medias, un nuovo video, passandogli i dati recuperati dal db, uso l'oggetto Video importato precedentemente */
        array_push($medias, new Video($id, $user, $path));
    } else {

        /* se il type è un immagine aggiungo all'array $medias, una nuova immagine, passandogli i dati recuperati dal db, uso l'oggetto Video importato precedentemente */
        array_push($medias, new Immagine($id, $user, $path));
    }
}

/* inizializzo la variabile posts, alla quale poi associerò tutti i post */
$posts = [];

/* Associo alla variabile $sqlAllMedias la query da fare al database per recuperare tutti i post */
$sqlAllPost = 'SELECT * FROM `posts` WHERE `id` < 31';

/* Uso la funzione query() per recuperare tutti i risultati e li associo alla varibile $allPosts  */
$allPosts = $connection->query($sqlAllPost);

/**
 * funzione per determinare se aggiungere una foto o un video
 * @param int $id l'id del post recuperato, per poi sottrargli 1 ed avere l'indice per il media
 * @param array $medias l'array che continene tutti i media, cosi da poter recupere le variabili d'istanze ed usarle per creare i video o immagini 
 * @return Video
 * @return Imagine
 */
function addVideoOrPhoto($id, $medias)
{
    if ($medias[$id - 1]->type === 'video') {

        /* se è un video uso l'oggetto video e gli passo i valori del media con indice id-1 */
        return new Video($medias[$id - 1]->id, $medias[$id - 1]->user, $medias[$id - 1]->path);
    } else {

        /* se è un immagine uso l'oggetto immagine e gli passo i valori del media con indice id-1 */
        return new Immagine($medias[$id - 1]->id, $medias[$id - 1]->user, $medias[$id - 1]->path);
    }
}

/* con l'iterazione while ciclo all'interno dei risulati ottenuti, con la funzione fetch_assoc() attribuisco a $row ad ogni iterazione un valore diverso 
fino a che attribuisco un valore il ciclo while continua, quando non ci sono più dati si interrompe */
while ($row = $allPosts->fetch_assoc()) {

    /* effettuo il destructring dell'oggetto attribuito alla varibile $row (i risultati della query.) */
    [
        'id' => $id,
        'user_id' => $user,
        'title' => $title,
        'date' => $date,
        'tags' => $tags
    ] = $row;

    /* aggiungo all'array $posts un nuovo oggetto post, passandolgi i valori recuperati dal destructuring
    per aggiungere il media uso la funzione addVideoOrPhoto(), per determinare se aggiungere un video o una foto.
    */
    array_push($posts, new Post($id, $user, $title, $date, $tags, addVideoOrPhoto($id, $medias)));
}

/* Chiudo la connesione con il Database */
DB::Close($connection);
?>

<!doctype html>
<html lang="en">

<!-- /* require file head.php  */ -->
<?php require_once __DIR__ . '/head.php' ?>

<!-- /* require file header.php  */ -->
<?php require_once __DIR__ . '/header.php' ?>

<main>
    <div class="container">
        <h3 class="text-center text-uppercase m-5">Objects</h3>
        <table class="table mt-3">
            <thead>
                <tr class="">
                    <th scope="col">ID</th>
                    <th scope="col">USER ID</th>
                    <th scope="col">TITLE</th>
                    <th scope="col">DATE</th>
                    <th scope="col">TAGS</th>
                    <th scope="col">ID MEDIA</th>
                    <th scope="col">USER MEDIA</th>
                    <th scope="col">PATH MEDIA</th>
                    <th scope="col">TYPE MEDIA</th>

                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                /* effettuo un foreach per ciclare all'interno dell'array posts che contiene tutti i post */
                foreach ($posts as $post) :
                ?>
                    <!-- qui con un operatore ternario stabilisco se è un video gli passo la class 'table-secondary' altrimenti la class table-ligth -->
                    <tr class="p-3 <?php echo $post->media->type === 'video' ?  'table-secondary' : 'table-ligth'; ?>">
                        <th scope="row"><?= $post->id; ?></th>
                        <td><?= $post->user; ?></td>
                        <td><?= $post->title; ?></td>
                        <!-- richiamo il metodo dell'oggetto $post che mi fa recuperare la data e l'orario del post
                        volendo posso anche recuperare solo la data con il metodo getDataPublisher() -->
                        <td><?= $post->getDataTimePublisher(); ?></td>
                        <td>
                            <!-- sistemo la stringa dei tags, rimuovendo sia le virgolette ('"') e sia le parentisi quadre ('[') (']') -->
                            <?= str_replace('"', '', str_replace(']', '', str_replace('[', '', $post->tags))); ?>
                        </td>
                        <td><?= $post->media->id; ?></td>
                        <td><?= $post->media->user; ?></td>
                        <!-- recupero il path richiamando il metodo getPath() dell'oggetto Media -->
                        <td><?= $post->media->getPath(); ?></td>
                        <td><?= $post->media->type; ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<!-- /* require file footer.php  */ -->
<?php require_once __DIR__ . '/footer.php' ?>

</html>