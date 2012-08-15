<?php

namespace Scrilex;

abstract class Repository extends \Knp\Repository
{
    public function findOneBy(array $wheres)
    {
        return $this->findBy($wheres, true);
    }
    
    public function findBy(array $wheres, $one = false)
    {
        $array = array();
        
        $sql = 'SELECT * FROM %s WHERE ';
        $i = 0;
        foreach ($wheres as $key => $value) {
            if($i > 0) $sql .= ' AND ';
            $sql .= sprintf('%s = ?', $key);
            $array[] = $value;
            $i++;
        }
        
        if($one) $sql .= ' LIMIT 1';

        $results = $this->db->fetchAll(sprintf($sql, $this->getTableName()), $array);
        if(!$results) return false;
        
        $length = ($one) ? 1 : count($results);
        
        $entities = array();
        for($i = 0; $i < $length; $i++)
        {
            $entities[] = $this->convertToEntity($results[$i]);
        }
        
        if($one) return $entities[0];
        else return $entities;
    }
    
    public function lastInsertId()
    {
        return $this->db->lastInsertId($this->getTableName().'_id');
    }
    
    public abstract function getEntityClass();
    
     /**
     * Returns a record by supplied id
     * 
     * @param mixed $id 
     * @return array
     */
    public function find($id)
    {
        return $this->convertToEntity(parent::find($id));
    }

    /**
     * Returns all records from this repository's table
     * 
     * @return array
     */
    public function findAll()
    {
        $users = array();
        foreach(parent::findAll() as $user)
        {
            $users[] = $this->convertToEntity($user);
        }
        return $users;
    }
    
    private function convertToEntity($array)
    {
        $class = $this->getEntityClass();
        return new $class($array);
    }
}