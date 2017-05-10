<?php
$connect_error = 'sorry we are experiencing downtime';
//mysql_connect('','whatscookin','bananas') or die($connect_error);
mysql_connect('localhost','root','') or die($connect_error);
//echo mysql_query("select id from user");
//mysql_select_db('whatscookin') or die($connect_error);
mysql_select_db('whatscookin') or die($connect_error);
?>