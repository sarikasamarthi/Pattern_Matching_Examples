<?php
        //URL validation.
 		if(isset($_POST['url'] ) == true && empty($_POST['url']) == false) {
    			$url = $_POST['url'];
				if(filter_var($url,FILTER_VALIDATE_URL) == true) {
?>
 		<h2> You entered a valid URL.Please check the output file for project output data. </h2>
<?php
	   	    	$file= $url;
	   			$read=fopen($file,"r") or die("can't open file");
	   			$write = "./Output.txt"; 
	   			$writefile = fopen($write, 'w') or die("can't open file");

	   			while(!feof($read)) {
				
							$post=fgets($read);
			                //Regular Expression for Name
							if(preg_match('#<h1 id="(.*)">(.*)</h1>#i',$post))	{
										$post=fgetss($read);
	 									fwrite($writefile,"Name : ".$post."\n");
							}
							//Regular Expression for Education
							else if(preg_match('#<h2>Education<\/h2>#i',$post)) {
										$post=fgetss($read);	
										if(!empty($post)){
												$post=fgetss($read);
												fwrite($writefile,"Education : ".$post."\n");
										}
							}
							//Regular Expression for Research Interests
							else if(preg_match('#<h2>Research Interests<\/h2>#i',$post)) {
										$post=fgets($read);	
		  								if(!empty($post)) { 
											$post=fgetss($read);
											$t = explode(",",$post);		
											for($i =0;$i<3;$i++)
				 									fwrite($writefile,"Research Interest ".($i+1)." : ".$t[$i]."\n"); 		
										}
							}
							//Regular Expression for Email
							else if(preg_match('#<h2>E-Mail<\/h2>#i',$post)) {
	    					//if(preg_match_all('#(^<img src="/common/email-image.php?user=)?(.*)^(&domain=)?(.*)([^">]+)#i',$post,$matches)){
							 if('/([^?&=#]+)=([^&#]*)/',$post,$matches) {
			 							   $post=fgets($read);
									     /*  if(!empty($post)) {
												$post=fgets($read);
												$user = substr($post,39,4);
												$domain = substr($post,51,11);
												fwrite($writefile,"Email : ".$user."@".$domain."\n");
											}*/
											fwrite($writefile,"Email:".$matches[0]."@".$matches[1]."\n");
								}			
		
							}
							//Regular Expression for webpage
							else if(preg_match("#<h2>Webpage<\/h2>#i",$post)) {
													$post=fgetss($read);	
													fwrite($writefile,"Webpage : ".$post."\n");
							}
					}

			} else {
?>
	     					<h2>Sorry,You Entered Invalid URL</h2>
<?php
	  		  } 
 		}
?>

				<form action="" method="post">
				       <div align="center">
				       <h1>Formal Langauge Course Mini Project</h1>
					   </div>
				        <ul>
     						<li>
	  							 *Enter Faculty Page URL:<br>  
 							     <input type="text" name="url" />
 							     <input type="submit"  value="submit"/>
							</li>
						</ul>
				</form>
