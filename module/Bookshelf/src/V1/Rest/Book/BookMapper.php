<?php
namespace Bookshelf\V1\Rest\Book;

use Zend\Db\Sql\Select;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\ResultSet\HydratingResultSet;

class BookMapper
{
    protected $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function fetchAll($filter = [])
    {
        $select = new Select('books');
        if (isset($filter['title'])) {
            $select->where(array('title LIKE ?' => '%'.$filter['title'].'%'));
        }

        $resultset = new HydratingResultSet;
        $resultset->setObjectPrototype(new BookEntity);

        $paginatorAdapter = new DbSelect(
            $select,
            $this->adapter,
            $resultset
        );

        $collection = new BookCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchByAuthor($authorId)
    {
        $select = new Select('books');
        $select->where(array('author_id' => $authorId));

        $resultset = new HydratingResultSet;
        $resultset->setObjectPrototype(new BookEntity);

        $paginatorAdapter = new DbSelect(
            $select,
            $this->adapter,
            $resultset
        );

        $collection = new BookCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchByAuthor1($authorId)
    {
        $sql = 'SELECT * FROM books WHERE author_id = ?';
        $resultset = $this->adapter->query($sql, array($authorId));
        $data = $resultset->toArray();

        if (!$data) {
            return false;
        }

        $books = [];
        foreach ($data as $item) {
            $entity = new BookEntity();
            $entity->populate($item);
            $books[] = $entity;
        }

        return $data;
    }

    public function fetchOne($bookId)
    {
        $sql = 'SELECT * FROM books WHERE id = ?';
        $resultset = $this->adapter->query($sql, array($bookId));
        $data = $resultset->toArray();

        if (!$data) {
            return false;
        }

        $entity = new BookEntity();
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
            $sql = 'UPDATE books
                SET
                    author_id = :author_id,
                    title = :title,
                    isbn = :isbn,
                    description = :description
                WHERE id = :id';
            $result = $this->adapter->query($sql, $data);
        } else {
            $sql = 'INSERT INTO books (author_id, title, isbn, description)
                VALUES (:author_id, :title, :isbn, :description)';
            $result = $this->adapter->query($sql, $data);

            $data['id']= $this->adapter->getDriver()->getLastGeneratedValue();
        }
        $entity = new BookEntity();
        $entity->populate($data);
        return $entity;
    }
}
