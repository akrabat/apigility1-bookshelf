<?php
namespace Bookshelf\V1\Rest\Author;

class AuthorEntity
{
    protected $id;
    protected $name;
    protected $biography;

    protected $books;

    public function setBooks($books)
    {
        $this->books = $books;
    }

    public function getBooks()
    {
        return $this->books;
    }

    public function getArrayCopy()
    {
        $data = [
            'id'        => $this->id,
            'name'      => $this->name,
            'biography' => $this->biography,
        ];

        if ($this->books) {
            $data['books'] = $this->books;
        }

        return $data;
    }

    public function populate(array $array)
    {
        $this->id        = $array['id'];
        $this->name      = $array['name'];
        $this->biography = $array['biography'];

        if (array_key_exists('books', $array)) {
            $this->books = $array['books'];
        }
    }
}
