<?php


namespace fyreplace\database;


use fyreplace\util\IteratorUtils;
use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Driver\Cursor;
use MongoDB\InsertOneResult;

class Database {

    private Client $mongo;
    private string $dbName;
    private Collection $collection;

    public function __construct(
        private string $className
    ) {
        //TODO: Replace database.ini with Settings and update fyreplace script to allow setting via command line
        $settings = parse_ini_file("database.ini");
        $user = $settings['username'];
        $pass = $settings['password'];
        $host = $settings['host'];
        $port = $settings['port'];
        $this->dbName = $settings['database'];
        $this->mongo = new Client("mongodb://$user:$pass@$host:$port");
        $this->setupDatabase();
        $this->collection = $this->mongo->{$this->dbName}->{$this->className};
    }

    /**
     * Creates the collection if it doesn't already exist
     * Also has the side effect of creating the database if it hasn't already been created
     */
    private function setupDatabase(): void{
        //If the collection is not contained in the database yet
        if(!IteratorUtils::contains(
            $this->mongo->{$this->dbName}->listCollectionNames(),
            $this->className
        )){
            $this->mongo->{$this->dbName}->createCollection($this->className);
        }
    }

    /**
     * Finds all documents in the collection
     * @return Cursor Cursor with all the documents in the collection
     */
    public function findAll(): Cursor {
        return $this->collection->find();
    }

    /**
     * Finds all documents matching a filter in the collection
     * @param array $filter filter to search the documents by
     * @return Cursor Cursor with all documents in the collection that match the filter
     */
    public function find(array $filter): Cursor {
        return $this->collection->find($filter);
    }

    //For now assuming it will always return either null or array

    /**
     * Finds one document that matches the filter in the collection
     * @param array $filter filter to search the documents by
     * @return array|null Array containing data from the document, null if no document matched the filter
     */
    public function findOne(array $filter): ?array {
        return $this->collection->findOne($filter);
    }

    public function insert(): InsertOneResult {

    }

    private function serializeToArray(){

    }



}