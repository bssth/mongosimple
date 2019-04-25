<?php
namespace Mike4ip;

use MongoDB\BSON\ObjectId;
use \MongoDB\Client;
use \MongoDB\Driver\Manager;
use \MongoDB\Database;
use \MongoDB\Driver\Cursor;

/**
 * Class MongoSimple
 * @package Mike4ip
 */
class MongoSimple
{
    /**
     * @var Database
     */
    protected $db;

    /**
     * @var string
     */
    protected $database;

    /**
     * @var Manager
     */
    protected $mgr;

    /**
     * DB constructor.
     * @param string $conn
     * @param string $db
     */
    public function __construct(string $conn, string $db)
    {
        $this->database = $db;
        $this->db = (new Client($conn))->{$db};
        $this->mgr = new Manager($conn);
    }

    /**
     * @return \MongoDB\Driver\ReadPreference
     */
    public function stats()
    {
        return $this->mgr->getReadPreference();
    }

    /**
     * @param string $table
     * @return \MongoDB\Collection
     */
    public function select(string $table)
    {
        return $this->db->{$table};
    }

    /**
     * @param string $table
     * @param array $array
     * @return ObjectId
     */
    public function insert(string $table, array $array): ObjectId
    {
        $collection = $this->db->{$table};
        $result = $collection->insertOne($array);
        return $result->getInsertedId();
    }

    /**
     * @param string $table
     * @param array $array
     * @return int
     */
    public function delete(string $table, array $array): int
    {
        $collection = $this->db->{$table};
        $result = $collection->deleteMany($array);
        return (int)$result->getDeletedCount();
    }

    /**
     * @param string $table
     * @param array $query
     * @param array|null $opt
     * @return Cursor
     */
    public function find(string $table, array $query, $opt = null): Cursor
    {
        $collection = $this->db->{$table};
        return $collection->find($query, is_array($opt) ? $opt : []);
    }

    /**
     * @param string $table
     * @param array $query
     * @param array|null $opt
     * @return int
     */
    public function count(string $table, array $query, $opt = null): int
    {
        $collection = $this->db->{$table};
        return $collection->countDocuments($query, is_array($opt) ? $opt : []);
    }

    /**
     * @param string $table
     * @param array $query
     * @param array $set
     * @return int
     */
    public function update(string $table, array $query, array $set): int
    {
        $collection = $this->db->{$table};
        return (int)$collection->updateMany($query, ['$set' => $set])->getModifiedCount();
    }

    /**
     * @param string $table
     * @param array $query
     * @param array $set
     * @return int
     */
    public function upsert(string $table, array $query, array $set): int
    {
        $collection = $this->db->{$table};
        return (int)$collection->replaceOne($query, $set, ['upsert' => true])->getModifiedCount();
    }

    /**
     * @param string $table
     * @param array $query
     * @param array $set
     * @return bool
     */
    public function updateOne(string $table, array $query, array $set): bool
    {
        $collection = $this->db->{$table};
        return (bool)$collection->updateOne($query, ['$set' => $set])->getModifiedCount();
    }

    /**
     * @param string $table
     * @param array $query
     * @return object|null
     */
    public function findOne(string $table, array $query)
    {
        $collection = $this->db->{$table};
        return $collection->findOne($query);
    }

    /**
     * @return array
     */
    public function getClasses()
    {
        return [$this->database, $this->db, $this->mgr];
    }
}