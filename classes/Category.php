<?php
/**
 * @author Kaiste Ventures Limited
 * @copyright (c) 2015, Kaiste Ventures Limited
 */

/** Class Category holds detail of individual category created or to be created
 * @property int $id Catgeory Id
 * @property string $name Category name
 * @property string $meta Category meta description
 * @property string $title Category web page title
 * @property int $parent ParentId of this category object
 */
class Category implements ContentManipulator{
    private $id;
    private $name;
    private $meta;
    private $title;
    private $parent=0;
    
    //Class Constructor
    /** Class Category holds detail of individual category created or to be created */
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
    /** Method that fetches categories from database
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return Array Category list
     */
    public function fetch($dbObj, $column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM categories ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM categories WHERE $condition ORDER BY $sort";}
        $result = $dbObj->fetchAssoc($sql);
        return $result;
    }
    
    /** Method for fetching formatted categories from database
     * @param Object $dbObj Database connectivity and manipulation object
     * @param string $parentTag Category list html tag that will serve as the root element. The default is ul tag.
     * @param string $childTag Category list html tag that will serve as the child tag to the $parentTag. The default tag is li tag.
     * @param string $fetchedCatIdHolder String that holds the fetched category_id of each of the categories fetched. The default value is '[parent-identity-code]'
     * @param integer $id The category_id of the categories to be fetched with its sub-categories. The default value is 0.
     * @return string Formatted Category list of items
     */
    public function fetchFormatted($dbObj, $parentTag='<ul>', $childTag='<li>', $fetchedCatIdHolder='[parent-identity-code]', $id=0) {
        $categories = $dbObj->fetchAssoc("SELECT * FROM categories WHERE parent=$id ORDER BY name ASC");
        $list = $parentTag;
            foreach($categories as $row) {
                $list .= str_replace($fetchedCatIdHolder, $row['id'], $childTag).$row['name'];
                    $list .= $this->fetchFormatted($dbObj,$parentTag, $childTag, $fetchedCatIdHolder, $row['id']);
                $list .= str_replace('<','</',substr($childTag, 0,3).'>');
            }
        $list .= str_replace('<','</',substr($parentTag, 0,3).'>');
        return $list;
    }
    
    /** Method that adds category to list of categories
     * @param object $dbObj Database connectivity and manipulation object
     * @return String Operation status: 'success|error'
     */
    public function add($dbObj){
        $sql = "INSERT INTO categories(name, meta, title, parent) VALUES ('{$this->name}', '{$this->meta}', '{$this->title}', '{$this->parent}')";
        if($this->notEmpty($this->title, $this->meta, $this->name)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }
    
    /** Method that update details of a category
     * @param object $dbObj Database connectivity and manipulation object
     * @return String Operation status: 'success|error'
     */
    public function update($dbObj){
        $sql = "UPDATE categories SET name = '{$this->name}', meta = '{$this->meta}', title = '{$this->title}', parent = '{$this->parent}' WHERE id = $this->id ";
        if($this->notEmpty($this->id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }
    
    /** Method for deleting a category
     * @param object $dbObj Database connectivity and manipulation object
     * @return String Operation status: 'success|error'
     */
    public function delete($dbObj){
        $sql = "DELETE FROM categories WHERE id = $this->id ";
        $sql2 = "DELETE FROM categories WHERE parent = $this->id ";//also delete children categories too
        if($this->notEmpty($this->id)){
            $result = $dbObj->query($sql); $result2 = $dbObj->query($sql2);
            if($result !== false && $result2 !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }
    
    /** getName() fetches the anme of a category using the category $id
     * @param object $dbObj Database connectivity and manipulation object
     * @param int $id Category id of the category whose name is to be fetched
     * @return string Name of the category
     */
    public static function getName($dbObj, $id) {
        $thisCatName = '';
        $thisCatNames = $dbObj->fetchNum("SELECT name FROM categories WHERE id = '{$id}' LIMIT 1");
        foreach ($thisCatNames as $thisCatNames) { $thisCatName = $thisCatNames[0]; }
        return $thisCatName;
    }
    
}
