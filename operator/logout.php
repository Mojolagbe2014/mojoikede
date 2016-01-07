<?php
session_start();
include '../classes/WebPage.php';

$thisPage = new WebPage('../includes/constants.php');

if($_SESSION['LoggedIn'] == true){
    session_destroy();
    $thisPage->redirectTo('./?'.  base64_encode('loggedout'));
    exit;
}

 
