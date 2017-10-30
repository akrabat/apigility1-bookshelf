<?php
return [
    'service_manager' => [
        'factories' => [
            \Bookshelf\V1\Rest\Author\AuthorResource::class => \Bookshelf\V1\Rest\Author\AuthorResourceFactory::class,
            \Bookshelf\V1\Rest\Author\AuthorMapper::class => \Bookshelf\V1\Rest\Author\AuthorMapperFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'bookshelf.rest.author' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/authors[/:author_id]',
                    'defaults' => [
                        'controller' => 'Bookshelf\\V1\\Rest\\Author\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'bookshelf.rest.author',
        ],
    ],
    'zf-rest' => [
        'Bookshelf\\V1\\Rest\\Author\\Controller' => [
            'listener' => \Bookshelf\V1\Rest\Author\AuthorResource::class,
            'route_name' => 'bookshelf.rest.author',
            'route_identifier_name' => 'author_id',
            'collection_name' => 'author',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Bookshelf\V1\Rest\Author\AuthorEntity::class,
            'collection_class' => \Bookshelf\V1\Rest\Author\AuthorCollection::class,
            'service_name' => 'Author',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Bookshelf\\V1\\Rest\\Author\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Bookshelf\\V1\\Rest\\Author\\Controller' => [
                0 => 'application/vnd.bookshelf.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Bookshelf\\V1\\Rest\\Author\\Controller' => [
                0 => 'application/vnd.bookshelf.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Bookshelf\V1\Rest\Author\AuthorEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'bookshelf.rest.author',
                'route_identifier_name' => 'author_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Bookshelf\V1\Rest\Author\AuthorCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'bookshelf.rest.author',
                'route_identifier_name' => 'author_id',
                'is_collection' => true,
            ],
        ],
    ],
];
