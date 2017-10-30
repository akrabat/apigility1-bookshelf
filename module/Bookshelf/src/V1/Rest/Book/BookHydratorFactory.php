<?php
namespace Bookshelf\V1\Rest\Book;

use Bookshelf\V1\Rest\Author\AuthorMapper;

class BookHydratorFactory
{
    public function __invoke($services)
    {
        return new BookHydrator(
            $services->get(AuthorMapper::class)
        );
    }
}
