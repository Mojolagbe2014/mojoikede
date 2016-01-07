<?php
session_start();
include '../classes/WebPage.php';
$thisPage = new WebPage('../includes/constants.php');

$errorArr = array(); //Array of errors


$dbObj = new Database(); //create database object
$thisUser = new User();//Create user object

//Login Handler
if(filter_input(INPUT_POST, "password1")!==NULL){
    $postVars = ['password1','password', 'passwordagain']; // Login Form field names
    foreach ($postVars as $postVar){//Check if empty 
        switch ($postVar){
            case 'passwordagain': if(filter_input(INPUT_POST,$postVar) !== filter_input(INPUT_POST, "password")){array_push ($errorArr, "Password Mismatch !!! ");if(filter_input(INPUT_POST, $postVar) == "") {array_push ($errorArr, "Please confirm your password. ");}}
            default : if(filter_input(INPUT_POST, $postVar) == "") {array_push ($errorArr, "Please enter a $postVar ");}
        }
    }
    if(count($errorArr) < 1){
        $thisUser->password = mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, 'password1'));
        $thisUser->id = $_SESSION['USERID'];
        $newPassword =  mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, 'password'));
        switch ($thisUser->changePassword($dbObj,'users', $newPassword)){
            case 'success': $_SESSION['topmsg'] = $thisPage->messageBox('Password successfully changed.', 'success'); $thisPage->redirectTo($_SERVER['HTTP_REFERER']); break;
            case 'error': $_SESSION['topmsg'] = $thisPage->messageBox('Password update failed. Please re-enter your details.', 'error'); $thisPage->redirectTo($_SERVER['HTTP_REFERER']); break;
        }
    } 
    else{ $_SESSION['topmsg'] = $thisPage->showError($errorArr); $thisPage->redirectTo($_SERVER['HTTP_REFERER']);}//Display error messages
}