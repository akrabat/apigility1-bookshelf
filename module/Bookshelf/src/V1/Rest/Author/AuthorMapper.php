<?php
namespace Bookshelf\V1\Rest\Author;

use Bookshelf\V1\Rest\Book\BookMapper;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;

class AuthorMapper
{
    protected $adapter;
    protected $bookMapper;

    public function __construct(AdapterInterface $adapter, BookMapper $bookMapper)
    {
        $this->adapter = $adapter;
        $this->bookMapper = $bookMapper;
    }

    public function fetchAll($filter = [])
    {
        $select = new Select('authors');
        if (isset($filter['name'])) {
            $select->where(['name LIKE ?' => '%'.$filter['name'].'%']);
        }
        if (isset($filter['id'])) {
            $select->where->equalTo('id', $filter['id']);
        }

        $resultset = new HydratingResultSet;
        $resultset->setObjectPrototype(new AuthorEntity);

        $paginatorAdapter = new DbSelect(
            $select,
            $this->adapter,
            $resultset
        );

        $collection = new AuthorCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchOne($authorId, $includeBooks = false)
    {
        $sql = 'SELECT * FROM authors WHERE id = ?';
        $resultset = $this->adapter->query($sql, array($authorId));
        $data = (array)$resultset->current();

        if (!$data) {
            return false;
        }

        $data['books'] = $this->bookMapper->fetchByAuthor($data['id']);

        $entity = new AuthorEntity();
        $entity->populate($data);

        return $entity;
    }

    public function save($data, $id = 0)
    {
        $data = (array)$data;
        if ($id > 0) {
            $data['id'] = $id;
        }

        if (isset($data['id'])) {
            $sql = 'UPDATE authors SET name = :name, biography = :biography WHERE id = :id';
            $result = $this->adapter->query($sql, $data);
        } else {
            $sql = 'INSERT INTO authors (name, biography) VALUES(:name, :biography)';
            $result = $this->adapter->query($sql, $data);

            $data['id']= $this->adapter->getDriver()->getLastGeneratedValue();
        }
        $entity = new AuthorEntity();
        $entity->populate($data);
        return $entity;
    }
}
