<?php
namespace Bookshelf\V1\Rest\Book;

class BookResourceFactory
{
    public function __invoke($services)
    {
        return new BookResource(
            $services->get(BookMapper::class)
        );
    }
}
