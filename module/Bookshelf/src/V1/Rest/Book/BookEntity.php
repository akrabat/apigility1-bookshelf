<?php
namespace Bookshelf\V1\Rest\Book;

class BookEntity
{
    protected $id;
    protected $author_id;
    protected $title;
    protected $isbn;
    protected $description;

    public function getArrayCopy()
    {
        return array(
            'id'          => $this->id,
            'author_id'   => $this->author_id,
            'title'       => $this->title,
            'isbn'        => $this->isbn,
            'description' => $this->description,
        );
    }

    public function populate(array $array)
    {
        $this->id          = $array['id'];
        $this->author_id   = $array['author_id'];
        $this->title       = $array['title'];
        $this->isbn        = $array['isbn'];
        $this->description = $array['description'];
    }
}
