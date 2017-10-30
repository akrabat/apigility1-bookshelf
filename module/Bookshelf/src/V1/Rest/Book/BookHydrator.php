<?php
namespace Bookshelf\V1\Rest\Book;

use Bookshelf\V1\Rest\Author\AuthorMapper;
use Zend\Hydrator\ArraySerializable;

class BookHydrator extends ArraySerializable
{
    protected $authorMapper;

    public function __construct($authorMapper = null)
    {
        parent::__construct();
        $this->authorMapper = $authorMapper;
    }

    public function extract($book)
    {
        $author = $this->authorMapper->fetchAll(['id' => $book->getAuthorId()]);
        $book->setAuthor($author);

        return parent::extract($book);
    }

    public function hydrate(array $data, $object)
    {
        return parent::hydrate($data, $object);
    }
}
