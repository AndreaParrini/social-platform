<?php
require __DIR__ . '/Models/Media.php';
require __DIR__ . '/Models/Post.php';
require __DIR__ . '/DB.php';


$connection = DB::Connect();

$sqlAllMedias = 'SELECT * FROM `medias` WHERE `id` < 31';
$allMedias = $connection->query($sqlAllMedias);

$medias = [];

while ($row = $allMedias->fetch_assoc()) {
    [
        'id' => $id,
        'user_id' => $user,
        'type' => $type,
        'path' => $path
    ] = $row;
    if ($type === 'video') {
        array_push($medias, new Video($id, $user, $path));
    } else {
        array_push($medias, new Immagine($id, $user, $path));
    }
}

$posts = [];
$sqlAllPost = 'SELECT * FROM `posts` WHERE `id` < 31';
$allPosts = $connection->query($sqlAllPost);

function addVideoOrPhoto($id, $medias)
{
    if ($medias[$id - 1]->type === 'video') {
        return new Video($medias[$id - 1]->id, $medias[$id - 1]->user, $medias[$id - 1]->path);
    } else {
        return new Immagine($medias[$id - 1]->id, $medias[$id - 1]->user, $medias[$id - 1]->path);
    }
}

while ($row = $allPosts->fetch_assoc()) {
    [
        'id' => $id,
        'user_id' => $user,
        'title' => $title,
        'date' => $date,
        'tags' => $tags
    ] = $row;
    array_push($posts, new Post($id, $user, $title, $date, $tags, addVideoOrPhoto($id, $medias)));
}
?>

<!doctype html>
<html lang="en">

<?php require_once __DIR__ . '/head.php' ?>
<?php require_once __DIR__ . '/header.php' ?>

<main>
    <div class="container">
        <table class="table table-striped mt-3">
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
                foreach ($posts as $post) :
                ?>
                    <tr class="p-3">
                        <th scope="row"><?= $post->id; ?></th>
                        <td><?= $post->user; ?></td>
                        <td><?= $post->title; ?></td>
                        <td><?= $post->getDataTimePublisher(); ?></td>
                        <td>
                            <?= str_replace('"', '', str_replace(']', '', str_replace('[', '', $post->tags))); ?>
                        </td>
                        <td><?= $post->media->id; ?></td>
                        <td><?= $post->media->user; ?></td>
                        <td><?= $post->media->getPath(); ?></td>
                        <td><?= $post->media->type; ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>


<?php require_once __DIR__ . '/footer.php' ?>

</html>