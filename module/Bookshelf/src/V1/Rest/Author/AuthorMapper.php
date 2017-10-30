<?php
namespace Bookshelf\V1\Rest\Author;

use Zend\Db\Sql\Select;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\ResultSet\HydratingResultSet;

class AuthorMapper
{
    protected $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function fetchAll($filter = [])
    {
        $select = new Select('authors');
        if (isset($filter['name'])) {
            $select->where(array('name LIKE ?' => '%'.$filter['name'].'%'));
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

    public function fetchOne($authorsId)
    {
        $sql = 'SELECT * FROM authors WHERE id = ?';
        $resultset = $this->adapter->query($sql, array($authorsId));
        $data = $resultset->toArray();

        if (!$data) {
            return false;
        }

        $entity = new AuthorEntity();
        $entity->populate($data[0]);

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
