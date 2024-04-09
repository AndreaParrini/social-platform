<?php

class Media
{
    public $id;
    public $user;
    public $path;

    public function __construct(int $id, int $user, string $path)
    {
        $this->id = $id;
        $this->user = $user;
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }
}

class Video extends Media
{
    public static $type = 'video';
    public function __construct(int $id, int $user, string $path)
    {
        parent::__construct($id, $user, $path);
    }
}

class Immagine extends Media
{
    public static $type = 'photo';
    public function __construct(int $id, int $user, string $path)
    {
        parent::__construct($id, $user, $path);
    }
}
