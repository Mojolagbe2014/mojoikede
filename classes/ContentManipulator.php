<?php
/**
 * @author Kaiste Ventures Limited
 * @copyright (c) 2015, Kaiste Ventures Limited
 */

/** Interface that defines CRUD operations on contents */
interface ContentManipulator {
    /** method that check if a string variable is empty */
    public function notEmpty();
    
    /** Method that add something to a content
     * @param Object $dbObj Database connectivity and manipulation object
     */
    public function add($dbObj);
    
    /** Method that  update content 
     * @param Object $dbObj Database connectivity and manipulation object
     */
    public function update($dbObj);
    
    /** Method that deletes content
     * @param Object $dbObj Database connectivity and manipulation object
     */
    public function delete($dbObj);
    
    /** Method that fetches content
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     */
    public function fetch($dbObj, $column="*", $condition="", $sort="id");
}
