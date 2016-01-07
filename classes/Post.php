<?php
/**
 * @author Kaiste Ventures Limited
 * @copyright (c) 2015, Kaiste Ventures Limited
 */

/** Post class represent individual blog posts 
 * @property int $id Post Id
 * @property string $title Post title
 * @property int $status Status of post whether validated or not. Values: '0|1'
 * @property string $content Post body/content body
 * @property Date $date Post submission date
 * @property string $featuredImage String path of the location of the post featured Image
 * @property string $metaDescription Post's web page meta description
 * @property string $category Category to which the post belongs
 */
class Post implements ContentManipulator{
    private $title;
    private $status = 0;
    private $content;
    private $date;
    private $featuredImage;
    private $metaDescription;
    private $category;
    private $id;

    /** Post class represent individual blog posts */
    function __construct() {
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
        $sql = "INSERT INTO posts(title, content, category, date, featured_image, meta_description, status) "
                ."VALUES ('{$this->title}','{$this->content}','{$this->category}',CURRENT_DATE,'{$this->featuredImage}','{$this->metaDescription}','{$this->status}')";
        if($this->notEmpty($this->title,$this->content,$this->category,$this->featuredImage,$this->metaDescription)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }

    /** Method that fetches posts from database
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     */
    public function fetch($dbObj, $column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM posts ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM posts WHERE $condition ORDER BY $sort";}
        $result = $dbObj->fetchAssoc($sql);
        return $result;
    }
    
    /** Method that update details of a post
     * @param object $dbObj Database connectivity and manipulation object
     */
    public function update($dbObj){
        $sql = "UPDATE posts SET title = '{$this->title}', content = '{$this->content}', category = '{$this->category}', featured_image = '{$this->featuredImage}', meta_description = '{$this->metaDescription}', status = '{$this->status}' WHERE id = $this->id ";
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
        $sql = "UPDATE posts SET $field = '{$value}' WHERE id = $id ";
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
        $sql = "DELETE FROM posts WHERE id = $this->id ";
        if($this->notEmpty($this->id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }

}