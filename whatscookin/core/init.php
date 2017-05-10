<?php
session_start();
//error_reporting(0);
require 'database/connect.php';
require 'functions/general.php';

if(logged_in() === true){
 $emailid = $_SESSION['emailid'];
 $user_data = user_data($emailid,'name');
 //echo  $user_data;
 }
$errors = array();
?>