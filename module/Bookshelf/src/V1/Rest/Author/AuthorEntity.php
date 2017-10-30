<?php
namespace Bookshelf\V1\Rest\Author;

class AuthorEntity
{
    protected $id;
    protected $name;
    protected $biography;

    public function getArrayCopy()
    {
        return array(
            'id'        => $this->id,
            'name'      => $this->name,
            'biography' => $this->biography,
        );
    }

    public function populate(array $array)
    {
        $this->id        = $array['id'];
        $this->name      = $array['name'];
        $this->biography = $array['biography'];
    }
}
