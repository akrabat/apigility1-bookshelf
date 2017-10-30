<?php
namespace Bookshelf\V1\Rest\Author;

class AuthorResourceFactory
{
    public function __invoke($services)
    {
        return new AuthorResource(
            $services->get(AuthorMapper::class)
        );
    }
}
