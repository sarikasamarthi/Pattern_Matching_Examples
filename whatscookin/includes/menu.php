   
<?php 
  if(logged_in() === true){
     ?>
	 	 <nav>
            <ul>
                <li><a href="loggedin.php">Home</a></li>
				<li><a href="aboutus.php">About Us</a></li>
                <li><a href="contact.php">Contact us</a></li>
            </ul>
</nav>

	 <?php
  }
  else{
  ?>
  	 <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
				<li><a href="aboutus.php">About Us</a></li>
                <li><a href="contact.php">Contact us</a></li>
            </ul>
</nav>
  <?php
  }
?>