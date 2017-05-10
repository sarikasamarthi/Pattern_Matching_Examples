<?php
function user_exists($emailid){
	$query=mysql_query("SELECT count(emailid) FROM user WHERE emailid='$emailid'");
	return (mysql_result($query,0)==1)?true:false;
}
function login($emailid,$password){
	$query = mysql_query("SELECT COUNT(emailid) FROM user WHERE emailid='$emailid' AND password='$password'");
	return (mysql_result($query,0)==1)? $emailid : false;
}
function output_errors($errors){
 	$output = array();
 	foreach($errors as $error){
  			$output[] = '<li>' . $error . '</li>';
	}
 	return '<ul><li>' . implode('</li><li>',$output) . '</li></ul>';
}
function logged_in(){
  return(isset($_SESSION['emailid'])) ? true : false;
}
function user_data($emailid){
 	$query = mysql_query("SELECT name FROM user WHERE emailid='$emailid'");
	$data = mysql_fetch_assoc($query);
	return $data ;
}
function user_count(){
  return mysql_result(mysql_query("SELECT COUNT(emailid) FROM user"),0);
}

function add_recipe($recipename,$calories,$cookingtime,$procedure,$ingredients){
 mysql_query("INSERT INTO recipe(recipename,recipecalories,recipetime,recipeprocedure,ingredients) VALUES('$recipename','$calories','$cookingtime','$procedure','$ingredients')"); 
}
/*function add_recipe($recipename,$calories,$cookingtime,$procedure){
 mysql_query("INSERT INTO recipe(name,time,calories,instructions) VALUES('$recipename','$cookingtime','$calories','$procedure')");
}*/

?>