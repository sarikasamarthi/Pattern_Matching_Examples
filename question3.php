<?php
//INPUT FILE
$file="question3.txt";
//echo $file;
//OPEN INPUT FILE TO READ THE DATA
$read=fopen($file,"r") or die ("Cannot open file");
//CREATE THE OUTPUT FILE TO WRITE THE DATA
$write='./question3phpoutput.txt';
$writefile=fopen($write,'w') or die('Cannot Open output File');

//READ TILL THE END OF THE FILE
while(!feof($read)){
	
	//USING fgets FUNCTION READ THE DATA
	$post=fgets($read);
	
	//REGULAR EXPRESSION FOR EMAILID EXTRACTION
	if(preg_match('/[\w+]*@+[\w+\.]*/',$post,$matches)){
		//PRINT ON THE SCREEN
		 echo $matches[0]."\n";
		//WRITE TO THE FILE
		 fwrite($writefile,$matches[0]."\n");
	}
	
	//REPLACE 'STUDENT' WITH 'SPACE' USING PREG_REPLACE FUNCTION
	$post=preg_replace('/student/','',$post);
	
	//REPLACE ',' WITH 'SPACE'
	$post=preg_replace('/\,/',' ',$post);

	//REPLACE 'EMAILID' WITH 'SPACE'
	$post=preg_replace('/[\w+]*@+[\w+\.]*/','',$post);

	//REPLACE 'NETID' SORROUNDED BY SPACE WITH 'SPACE'
	if(preg_match('/[\s]*[\w]+[\s]*$/',$post))
	$post=preg_replace('/[\s]*[\w]+[\s]*$/','',$post);
	
	//REPLACE 'SPACE' BETWEEN NAMES WITH '_'
	$space='/[ ]+/';
	$replace='_';
	$post=preg_replace($space,$replace,$post);
	echo $post."\n";
	fwrite($writefile,$post."\n\n");
}

?>


