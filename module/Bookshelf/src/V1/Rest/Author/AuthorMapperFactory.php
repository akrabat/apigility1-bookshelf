<?php
namespace Bookshelf\V1\Rest\Author;

class AuthorMapperFactory
{
    public function __invoke($services)
    {
        return new AuthorMapper(
            $services->get('db-bookshelf')
        );
    }
}
