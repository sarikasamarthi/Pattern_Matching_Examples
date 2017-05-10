<?php include 'core/init.php' ?>
<?php include 'includes/overall/header.php';?>
<?php
				$i=0;
  		 		//if(isset($_FILES['uploadedfile']) === true && empty($_FILES['uploadedfile']['name']) === true){
				//if(isset($_POST['uploadedfile'] ) == true && empty($_POST['uploadedfile']) == false) {
			    			if(empty($_FILES['uploadedfile']['name']) === true){
			             					$errors[] = 'Please choose a file';
											//echo 'Please choose a file';
			    			}else{
			          					$uploadedfile = $_FILES['uploadedfile']['name'];
		            					$file=$uploadedfile;
										echo "$file<br>";
									    $read=fopen($file,"r") or die("can't open file");
										while(!feof($read)) {
													$post=fgets($read);
				
												if(preg_match('/RecipeName/i',$post)){
				   											$post=fgets($read);
															$recipename=$post;
															//echo "$recipename[$i}<br>";
												}
												if(preg_match('/Calories/i',$post)){
												            $post=fgets($read);
				   											$calories =$post;
															//echo "$calories[$i]<br>";
												}
												if(preg_match('/CookingTime/i',$post)){
														    $post=fgets($read);
				   											$cookingtime=$post;
															//echo "$cookingtime[$i]<br>";
												}
												if(preg_match('/Ingredients/i',$post)){
															$post=fgets($read);
														   //$t=explode(',',$post);
				  											$ingredients=$post;  
															//echo "$ingredients<br>";
															
												}
												if(preg_match('/Instructions/i',$post)){
												            $post=fgets($read);
															$procedure=$post;
															//echo "$procedure[$i]<br>";
															
												}
																						
												/*if(preg_match('#Image#i',$post)){
				 											$image=$post;
												}*/
												//add_recipe($recipename,$calories,$cookingtime,$ingredients,$procedure);
												//$i++;
												
												if(preg_match('/Cs5394/i',$post)){
													add_recipe($recipename,$calories,$cookingtime,$ingredients,$procedure);
												}
										}
										//add_recipe($recipename,$calories,$cookingtime,$ingredients,$procedure);
										//add_recipe($recipename,$calories,$cookingtime,$procedure);
								}
								/*foreach($i as $temp){
									add_recipe($recipename[$i],$calories[$i],$cookingtime[$i],$ingredients[$i],$procedure[$i]);
								}*/
							
						
							 if(empty($errors) === true){  
           							  //add_recipe($recipename,$calories,$cookingtime,$ingredients,$procedure);
										//header('Location:addrecipe.php');
							 ?>
									 <h1>INFORMATION POSTED SUCCESSFULLY!!!!!</h1>
							 <?php
									// header('Location:addrecipe.php');
									//exit();
							 }else if(empty($errors) === false){
						     					 echo output_errors($errors);
	         				  }
		
							 ?>
		
<form action="" method="post" enctype="multipart/form-data">
	<div align="center">
		<h1>Adding Recipe to Database</h1>
	</div>
	<ul>
   	  <li>
	  		*Choose your file to upload::<br>  
 			<input type="file" name="uploadedfile" />
            <input type="submit" name="submit" value="upload file"/>
</li>
	</ul>
</form>

<?php include 'includes/overall/footer.php';?>
