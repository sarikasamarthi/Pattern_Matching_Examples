<?php
include 'core/init.php';
if(empty($_POST) === false){
		$emailid = $_POST['emailid'];
		$password = $_POST['password'];
		if(empty($emailid) === true || empty($password) === true) {
    			 $errors[] = 'YOU NEED TO ENTER EMAILID AND PASSWORD' ;
		}
		else if(user_exists($emailid) ===  false)  {
     			$errors[] = 'We can\'t find the emailID.Have you registered?' ;
		}
		else  {
   
     		$login = login($emailid,$password);
   	 		if($login === false)   {
	  			$errors[] = 'Entered emailid/password combination is wrong';
	 		}else	{
	 			//set user session
	 			$_SESSION['emailid'] = $login;
	 			//forward to home page
	 			header('location:loggedin.php');
	 			exit();
	 			//echo 'OK!';
	  		 }
  		}
}  
else
 $errors[] = 'No data received'; 

include 'includes/overall/header.php';
//print_r($errors);
if(empty($errors) === false){
?>
		<h2> We tried to log you in,but ... </h2>
<?php
echo output_errors($errors);
}
include 'includes/overall/footer.php';
?>


