<?php
class Post
{

    public $id;
    public $name;
    public $content;
    public $created_at;

    public function __construct()
    {
        if (is_string($this->created_at)) {
            $this->created_at = new DateTime('@' . $this->created_at);
        }
    }

    public function getExcerpt(): string
    {
        return substr((string) $this->content, 0, 150);
    }

    public function getCreatedAt(): DateTime
    {
        if (!$this->created_at instanceof DateTime) {
            $this->created_at = new DateTime('@' . $this->created_at);
        }

        return $this->created_at;
    }
}
