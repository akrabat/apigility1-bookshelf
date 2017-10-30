<?php
namespace Bookshelf\V1\Rest\Book;

class BookMapperFactory
{
    public function __invoke($services)
    {
        return new BookMapper(
            $services->get('db-bookshelf')
        );
    }
}
