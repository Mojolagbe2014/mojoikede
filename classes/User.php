<?php
/**
 * @author Kaiste Ventures Limited
 * @copyright (c) 2015, Kaiste Ventures Limited
 */

/** Class User represents each appliction user */
class User{
    //put your code here
    private $id;
    private $password;
    private $username;
    private $fname;
    private $lname;
    private $role;
    private $dateRegistered = " CURRENT_DATE ";


    //Class Constructor
    /** Class User represents each appliction user */
    public function __construct() {
    }
    
    //Using Magic__set and __get
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    public function __set($property, $value) {
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
    
    /** User login method 
     * @param Object $dbObj Database connectivity and manipulation object
     * @param string $dbTable name of the database table from which a user should be checked
     * @return string String success or failure message: success|error
     */
    public function login($dbObj, $dbTable){
        $sql =  "SELECT * FROM $dbTable WHERE username = '{$this->username}' AND password = '".md5($this->password)."' LIMIT 1 ";
        $result = $dbObj->fetchAssoc($sql);
        if(count($result)> 0){
            foreach($result as $result){
                $_SESSION['LoggedIn'] = true;
                $_SESSION['LoggedUserName'] = $result['firstname'];
                $_SESSION['USERID'] = $result['id'];
                $_SESSION['USERTYPE'] = $result['role'];
                return 'success';
            }
        }
        else {return 'error';}
    }
    
    /** User creation/addition method 
     * @param Object $dbObj Database connectivity and manipulation object
     * @param string $dbTable name of the database table from which a user should be checked
     * @return string String success or failure message: success|error
     */
    public function add($dbObj, $dbTable){
        $sql = "INSERT INTO $dbTable(username, password, firstname, lastname, role, date_registered) "
            . "VALUES ('{$this->username}', '".md5($this->password)."', '{$this->fname}', '{$this->lname}', '{$this->role}', $this->dateRegistered)";
        $result = $dbObj->query($sql);
        if($result !== false){ return 'success'; }
        else{ return 'error';    }
    }
    
    /** Change Password
     * @param Object $dbObj Database connectivity and manipulation object
     * @param string $dbTable name of the database table from which a user should be checked
     * @param string $newPassword New password
     * @return string String success or failure message: success|error
     */
    public function changePassword($dbObj, $dbTable, $newPassword){
        $sql = "UPDATE $dbTable SET password = '".md5($newPassword)."' WHERE id = $this->id ";
        $pwdExists = $this->pwdExists($dbObj, $dbTable);//Check if old password is corect
        if($pwdExists==TRUE){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }
    
    /** pwdExists checks if a password truely exists in the database
     * @param Object $dbObj Database connectivity and manipulation object
     * @param string $dbTable name of the database table from which a user should be checked
     * @return Boolean True for exists, while false for not
     */
    private function pwdExists($dbObj, $dbTable){
        $sql =  "SELECT * FROM $dbTable WHERE password = '".md5($this->password)."' AND id = $this->id LIMIT 1 ";
        $result = $dbObj->fetchAssoc($sql);
        if($result != false){ return true; }
        else{ return false;    }
    } 
    
    /** update method updates user details
     * @param Object $dbObj Database connectivity and manipulation object
     * @param string $dbTable name of the database table from which a user should be checked
     * @return string Success or error message 
     */
    public function update($dbObj, $dbTable){
        $sql = "UPDATE $dbTable SET username = '{$this->username}', firstname='{$this->fname}', lastname='{$this->lname}', role='{$this->role}' WHERE id = $this->id ";
        if($this->notEmpty($this->id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }
    
    /** fetchById fetches all user details by id
     * @param Object $dbObj Database connectivity and manipulation object
     * @param string $dbTable name of the database table from which a user should be checked
     * @return Mixed Array or error message 
     */
    public function fetchById($dbObj, $dbTable) {
        $sql =  "SELECT * FROM $dbTable WHERE id = $this->id LIMIT 1 ";
        if($this->notEmpty($this->id)){
            $result = $dbObj->fetchAssoc($sql);
            if($result !== false){$_SESSION['LoggedUserName'] = $this->fname; return $result; }
            else{ return 'error';    }
        } else{return 'error'; }
    }
    
    /** fetch fetches all users
     * @param Object $dbObj Database connectivity and manipulation object
     * @param string $dbTable name of the database table from which a user should be checked
     * @return Mixed Array or error message 
     */
    public function fetch($dbObj, $dbTable) {
        $sql =  "SELECT * FROM $dbTable";
        $result = $dbObj->fetchAssoc($sql);
        if($result !== false){return $result; }
        else{ return 'error';    }
    }
    
    /** Method for deleting a user
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $dbTable TAble in the database for the users
     */
    public function delete($dbObj, $dbTable){
        $sql = "DELETE FROM $dbTable WHERE id = $this->id ";
        if($this->notEmpty($this->id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }
    
    /** updateSingle Method update details of a user
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $dbTable Table to be updated 
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id of the user to be updated
     * @return string Success or Error message
     */
    public static function updateSingle($dbObj, $dbTable, $field, $value, $id){
        $sql = "UPDATE $dbTable SET $field = '{$value}' WHERE id = $id ";
        if(!empty($dbObj) && !empty($dbTable) && !empty($field) && !empty($value) && !empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }
}
