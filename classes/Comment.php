<?php
/**
 * @author Kaiste Ventures Limited
 * @copyright (c) 2015, Kaiste Ventures Limited
 */

/** Class Comment reprents individual user's comments 
 * @property int $id Comment Id
 * @property string $email Email of the user commenting
 */
class Comment implements ContentManipulator{
    private $id;
    private $email;
    private $name;
    private $date = 'CURRENT_DATE';
    private $postId;
    
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
    
    
    public function add($dbObj) {
        
    }

    /** Method for deleting a comment
     * @param object $dbObj Database connectivity and manipulation object
     */
    public function delete($dbObj){
        $sql = "DELETE FROM comments WHERE id = $this->id ";
        if($this->notEmpty($this->id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }

    public function fetch($dbObj, $column = "*", $condition = "", $sort = "id") {
        $sql = "SELECT $column FROM comments ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM comments WHERE $condition ORDER BY $sort";}
        $result = $dbObj->fetchAssoc($sql);
        return $result;
    }

   /** Empty string checker  */
    public function notEmpty() {
        foreach (func_get_args() as $arg) {
            if (empty($arg)) { return false; } 
            else {continue; }
        }
        return true;
    }

    public function update($dbObj) {
        
    }

    /** Method that update details of a comment
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id of the comment to be updated
     */
    public static function updateSingle($dbObj, $field, $value, $id){
        $sql = "UPDATE comments SET $field = '{$value}' WHERE id = $id ";
        if(!empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }
}
