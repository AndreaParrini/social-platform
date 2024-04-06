## Query 1 -> Seleziona gli utenti che hanno postato almeno un video

- - - sql
SELECT `users`.*, COUNT(`media_post`.`media_id`) AS `total_video`
FROM `users`
JOIN `medias` ON `medias`.`user_id` = `users`.`id`
JOIN `media_post` ON `media_post`.`media_id` = `medias`.`id`
WHERE `medias`.`type` = 'video'
GROUP BY `users`.`id`;
- - - .


## Query 2 -> Seleziona tutti i post senza Like (13)

- - - sql
SELECT `posts`.*
FROM `posts`
LEFT JOIN `likes` ON `likes`.`post_id` = `posts`.`id`
WHERE `likes`.`post_id` IS NULL AND `likes`.`user_id` IS NULL;
- - - .


## Query 3 -> Conta il numero di like per ogni post (165)

- - - sql
SELECT `posts`.*, COUNT(`likes`.`post_id`) AS `total_like`
FROM `posts`
LEFT JOIN `likes` ON `likes`.`post_id` = `posts`.`id`
GROUP BY `posts`.`id`;
- - - .


## Query 4 -> Ordina gli utenti per il numero di media caricati (25) 

- - - sql
SELECT `users`.*, COUNT(`media_post`.`media_id`) AS `total_media`
FROM `users`
JOIN `medias` ON `medias`.`user_id` = `users`.`id`
JOIN `media_post` ON `media_post`.`media_id` = `medias`.`id`
GROUP BY `users`.`id`
ORDER BY `total_media`;
- - - .


## Query 5 -> Ordina gli utenti per totale di likes ricevuti nei loro posts (25) 

- - - sql
SELECT `users`.*, COUNT(`likes`.`post_id`) AS `total_like`
FROM `users`
JOIN `posts` ON `posts`.`user_id` = `users`.`id`
JOIN `likes` ON `likes`.`post_id` = `posts`.`id`
GROUP BY `users`.`id`
ORDER BY `total_like` DESC;
- - - .