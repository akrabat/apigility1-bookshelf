<?php
namespace Bookshelf\V1\Rest\Author;

use Bookshelf\V1\Rest\Book\BookMapper;

class AuthorMapperFactory
{
    public function __invoke($services)
    {
        return new AuthorMapper(
            $services->get('db-bookshelf'),
            $services->get(BookMapper::class)
        );
    }
}
