<?php
namespace Bookshelf\V1\Rest\Book;

class BookEntity
{
    protected $id;
    protected $author_id;
    protected $title;
    protected $isbn;
    protected $description;

    protected $author;

    public function getAuthorId()
    {
        return $this->author_id;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getArrayCopy()
    {
        return [
            'id'          => $this->id,
            'author_id'   => $this->author_id,
            'title'       => $this->title,
            'isbn'        => $this->isbn,
            'description' => $this->description,
        ];

        if ($this->books) {
            $data['author'] = $this->author;
        }

        return $data;
    }

    public function populate(array $array)
    {
        $this->id          = $array['id'];
        $this->author_id   = $array['author_id'];
        $this->title       = $array['title'];
        $this->isbn        = $array['isbn'];
        $this->description = $array['description'];

        if (array_key_exists('author', $array)) {
            $this->author = $array['author'];
        }
    }
}
