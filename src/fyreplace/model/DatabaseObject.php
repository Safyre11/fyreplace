<?php

namespace fyreplace\model;

use fyreplace\database\Database;
use fyreplace\util\ReflectionUtils;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\Unserializable;
use ReflectionClass;
use function PHPUnit\Framework\throwException;

abstract class DatabaseObject implements Serializable, Unserializable {

    private Database $database;
    private string $className;

    public function __construct() {
        $this->className = strtolower(ReflectionUtils::getShortName(get_class($this)));
        $this->database = new Database($this->className);
    }

    abstract protected function createObject();

    public function bsonSerialize(): array {
        $arr = array();
        try{
            $reflector = new ReflectionClass($this);
            $properties = $reflector->getProperties();
            foreach ($properties as $property){
                foreach (ReflectionUtils::parseDocComments($property->getDocComment()) as $annotation){
                    switch ($annotation){
                    case "ignore":
                        continue 3;
                    case "id":
                        if($property->getValue($this) !== null){
                            $arr['_id'] = $property->getValue($this);
                        }
                        break;
                    case "optional":
                        if($property->getValue($this) === null){
                            continue 3;
                        }
                    case "required":
                        if($property->getValue($this) === null){
                            throw new \ErrorException("Required property was null for ".$this->className);
                        }
                    default:
                        $arr[$property->getName()] = $property->getValue($this);
                }
                }
            }
        } catch (\ErrorException){

        }
        return $arr;
    }

    public function bsonUnserialize(array $data) {
        // TODO: Implement bsonUnserialize() method.
    }

}