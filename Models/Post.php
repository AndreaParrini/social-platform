<?php

class Post
{
    public $id;
    public $user;
    public $title;
    public $date;
    public $tags;

    /**
     * @param int $id the id of the post
     * @param int $user the id of the user by public the post
     * @param String $title decribe of the post
     * @param String $date format is "Y-m-d H:i:s"
     * @param array $tags the array that contain all tags of post
     */
    public function __construct(int $id, int $user, string $title, string $date, array $tags)
    {
        $this->id = $id;
        $this->user = $user;
        $this->title = $title;
        $this->date = $date;
        $this->tags = $tags;
    }

    /**
     * function to return data of the post
     */
    public function getDataPublisher()
    {
        $data = strtotime($this->date);
        $dataPublisher = date('d-m-Y', $data);
        return $dataPublisher;
    }
    /**
     * function to return data and time of the post
     */
    public function getDataTimePublisher()
    {
        $data = strtotime($this->date);
        $dataPublisher = date('d-m-Y H:i:s', $data);
        return $dataPublisher;
    }
}
