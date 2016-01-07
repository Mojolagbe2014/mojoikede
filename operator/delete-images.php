<?php
session_start();
include '../classes/WebPage.php'; //Set up page as a web page
$thisPage = new WebPage('../includes/constants.php'); //Create new instance of webPage class

//If user is not loggedIn reject the user 
if(!isset($_SESSION['LoggedIn'])){$thisPage->redirectTo('index');}//redirect user to login page

else{
    $basedir = '../media/';
    $file_to_delete = $_REQUEST["file"];  

    unlink($basedir.$file_to_delete);

    $_SESSION['topmsg'] = $thisPage->messageBox('Image ['.$file_to_delete. '] sucessfully deleted.', 'success');
    $thisPage->redirectTo('media');
}