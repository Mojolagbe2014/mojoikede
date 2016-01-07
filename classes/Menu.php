<?php

/**
 * Description of Menu
 *
 * @author Kaiste Ventures Limited
 * @copyright (c) 2015, Kaiste Ventures Limited
 * @property int $id Menu id 
 * @property stirng $title Title
 * @property string $link Url of the menu
 * @property string $type Type of menu wether category|custom link
 */

class Menu implements ContentManipulator{
    //Properties
    private $id;
    private $title;
    private $link;
    private $type;
    
    //Class constructor
    public function __construct(){
        
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
    
    /** Empty string checker  */
    public function notEmpty() {
        foreach (func_get_args() as $arg) {
            if (empty($arg)) { return false; } 
            else {continue; }
        }
        return true;
    }
    
    /** Method that submits a post 
     * @param object $dbObj Database object
     */
    function add($dbObj){
        $sql = "INSERT INTO menu(title, link, type) "
                ."VALUES ('{$this->title}','{$this->link}','{$this->type}')";
        if($this->notEmpty($this->title,$this->link,$this->type)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }

    /** Method that fetches menu from database
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     */
    public function fetch($dbObj, $column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM menu ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM menu WHERE $condition ORDER BY $sort";}
        $result = $dbObj->fetchAssoc($sql);
        return $result;
    }
    
    /** Method that update details of a post
     * @param object $dbObj Database connectivity and manipulation object
     */
    public function update($dbObj){
        $sql = "UPDATE menu SET title = '{$this->title}', link = '{$this->link}', type = '{$this->type}' WHERE id = $this->id ";
        if($this->notEmpty($this->id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }
    
    /** Method that update details of a post
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id of the post to be updated
     */
    public static function updateSingle($dbObj, $field, $value, $id){
        $sql = "UPDATE menu SET $field = '{$value}' WHERE id = $id ";
        if(!empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }
    
    /** Method for deleting a post
     * @param object $dbObj Database connectivity and manipulation object
     */
    public function delete($dbObj){
        $sql = "DELETE FROM menu WHERE id = $this->id ";
        if($this->notEmpty($this->id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }

}
