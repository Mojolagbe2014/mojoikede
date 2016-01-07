<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Advert
 *
 * @author Kaiste
 */
class Advert implements ContentManipulator{
    private $id;
    private $name;
    private $size;
    private $type;
    private $content;
    private $location = '';
    private $position;
    private $link;
    private $follow = 0;
    private $status = 0;
    
    //Class Constructor
    public function __construct() {
    }
    
    //Using Magic__set and __get
    function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
    
    /** Method that submits an advert 
     * @param object $dbObj Database object
     * @return String Operation status: 'success|error'
     */
    function add($dbObj){
        $sql = "INSERT INTO adverts(name, size, type, content, location, position, link, follow, status) "
                ."VALUES ('{$this->name}','{$this->size}','{$this->type}','{$this->content}','{$this->location}'"
                . ",'{$this->position}','{$this->link}','{$this->follow}','{$this->status}')";
        if($this->notEmpty($this->name,$this->size)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }

    /** Method for deleting an advert
     * @param object $dbObj Database connectivity and manipulation object
     * @return String Operation status: 'success|error'
     */
    public function delete($dbObj){
        $sql = "DELETE FROM adverts WHERE id = $this->id ";
        if($this->notEmpty($this->id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }

    /** Method that fetches adverts from database
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     */
    public function fetch($dbObj, $column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM adverts ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM adverts WHERE $condition ORDER BY $sort";}
        $result = $dbObj->fetchAssoc($sql);
        return $result;
    }

    /** Empty string checker  
     * @return Boolean True for not empty and false for empty
     */
    public function notEmpty() {
        foreach (func_get_args() as $arg) {
            if (empty($arg)) { return false; } 
            else {continue; }
        }
        return true;
    }

    /** Method that update details of an advert
     * @param object $dbObj Database connectivity and manipulation object
     * @return String Operation status: 'success|error'
     */
    public function update($dbObj){
        $sql = "UPDATE adverts SET name = '{$this->name}', size = '{$this->size}', type = '{$this->type}', content = '{$this->content}', location = '{$this->position}', position = '{$this->location}', link = '{$this->link}', follow = '{$this->follow}', status = '{$this->status}' WHERE id = $this->id ";
        if($this->notEmpty($this->id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }

    /** Method that update details of an advert
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id of the advert to be updated
     */
    public static function updateSingle($dbObj, $field, $value, $id){
        $sql = "UPDATE adverts SET $field = '{$value}' WHERE id = $id ";
        if(!empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }
}
