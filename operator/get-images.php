<?php
session_start();
include '../classes/WebPage.php'; //Set up page as a web page
$thisPage = new WebPage('../includes/constants.php'); //Create new instance of webPage class

//If user is not loggedIn reject the user 
if(!isset($_SESSION['LoggedIn'])){$thisPage->redirectTo('index');}//redirect user to login page

$filenameArray = [];

$handle = opendir(dirname(dirname(__FILE__)).'/media/');
while($file = readdir($handle)){
    if($file !== '.' && $file !== '..'){
        array_push($filenameArray, "../media/$file");
    }
}

echo json_encode($filenameArray);