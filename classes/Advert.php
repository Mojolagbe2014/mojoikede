<?php
/**
 * Description of Advert
 *
 * @author Kaiste
 */
class Advert implements ContentManipulator{
    private $id;
    private $name;
    private $link;
    private $format;
    private $follow = 0;
    private $status = 0;
    private $background;
    private $zoneOne;
    private $zoneOneAlt;
    private $zoneTwo;
    private $zoneTwoAlt;
    private $zoneThree;
    private static $tableName = "advert";
    
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
        $sql = "INSERT INTO ".self::$tableName." (name, link, format, follow, status, background, zone_one, zone_one_alt, zone_two, zone_two_alt, zone_three) "
                ."VALUES ('{$this->name}','{$this->link}','{$this->format}','{$this->follow}','{$this->status}'"
                . ",'{$this->background}','{$this->zoneOne}','{$this->zoneOneAlt}','{$this->zoneTwo}','{$this->zoneTwoAlt}','{$this->zoneThree}')";
        if($this->notEmpty($this->name,$this->background)){
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
        $sql = "DELETE FROM ".self::$tableName." WHERE id = $this->id ";
        if($this->notEmpty($this->id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }

    /** Method that fetches advert from database
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     */
    public function fetch($dbObj, $column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM ".self::$tableName." ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM ".self::$tableName." WHERE $condition ORDER BY $sort";}
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
        $sql = "UPDATE ".self::$tableName." SET name = '{$this->name}', link = '{$this->link}', format = '{$this->format}', content = '{$this->content}', location = '{$this->position}', position = '{$this->location}', link = '{$this->link}', follow = '{$this->follow}', status = '{$this->status}' WHERE id = $this->id ";
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
        $sql = "UPDATE ".self::$tableName." SET $field = '{$value}' WHERE id = $id ";
        if(!empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }
    
    /** getSingle() fetches a single column value
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $column Table's required column in the datatbase
     * @param int $id Advert id of the advert whose name is to be fetched
     * @return string Name of the advert
     */
    public static function getSingle($dbObj, $column, $id) {
        $field = intval($id) ? "id = '{$id}' " : " name LIKE '%{$id}%' ";
        $thisAsstReqVal = '';
        $thisAsstReqVals = $dbObj->fetchNum("SELECT $column FROM ".self::$tableName." WHERE $field ORDER BY id LIMIT 1");
        foreach ($thisAsstReqVals as $thisAsstReqVals) { $thisAsstReqVal = $thisAsstReqVals[0]; }
        return $thisAsstReqVal;
    }
}
