<html>
	 <style type="text/css">
				body {
						background-color: lightblue;
				}
				.style3 {
						color: black;
						font-family: "Times New Roman", Times, serif;
						font-weight: bold;
						font-size:18;
				}
		</style>
</html>
<?php

	/*$input=$_POST['input'];
		if(empty($input) === true){
			echo "PLEASE ENTER KEYWORD";
		}*/
	
 $input="java";
$url = "http://http://www.booksamillion.com/search?id=5993699391635&query=".$input ."&where=All&search.x=0&search.y=0&search=Search";

	 $curlhandle = curl_init($url);
        curl_setopt($curlhandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlhandle, CURLOPT_BINARYTRANSFER, true);
	 curl_setopt($curlhandle,CURLOPT_HEADER,0);
	 curl_setopt($curlhandle,CURLOPT_TIMEOUT,5);
    	
	 $result = curl_exec($curlhandle);
	  
	 curl_close($curlhandle);

	 $dom = new DOMDocument;
     $dom->loadHTML($result);	
     //echo $powells_dom->saveHTML();
     $xpath = new DOMXpath($dom);

    $booktitle = $xpath->query("//span[@class='title']");
    //print_r($title_data);
    $bookauthor = $xpath->query("//span[@class='byline']");
    $bookprice = $xpath->query("//span[@class='ebook-price']");

	
    $bookresults  = parseDataMillions($booktitle,$bookauthor,$bookprice);
	//echo $bookresults;
    $bookresults = sortBookPriceMillions($bookresults);

	
	$finalresults;
	$count = 0;
	
	for($i = 0; $i <count($bookresults);$i++){
		$finalresults[$count++] =  $bookresults[$i];
	}	

	$finalresults = sortBookPriceMillions($finalresults);
	echo $finalresults."<br/>";
       $limit=40;
	displayResults($finalresults,$limit);
       echo $finalresults."<br/>";
  
       exit(0);

	function parseDataMillions($booktitle,$bookauthor,$bookprice) {
	   
	   $bookresults = array();
          $i = 0;
	   $j= 0;

	   while($i< $booktitle->length){
				
            $title = $booktitle->item($i);
			$author= $bookauthor->item($i);
			$price = $bookprice->item($i);

		   if(strcmp($title->nodeValue, "") != 0 && strcmp($author->nodeValue, "") != 0 && strcmp($price->nodeValue, "") != 0){							
				$bookresults[$j] = $title->nodeValue . "|" . $author->nodeValue . "|" . $price->nodeValue;
				echo $bookresults[$j]."<br/>";
				$j++;
			}
            $i++;
         }
		 return $bookresults;
   }
	
   function sortBookPriceMillions($localresults)	{
		$index = 0;
		for ($i=0;$i<count($localresults);$i++) 	{			
			$index=$i;
			for ($j= $i+1;$j<count($localresults);$j++) {
				$temp = explode("|" , $localresults[$j]);
				$temp1 = explode("|" , $localresults[$index]);
				if (($temp[3]*100)< ($temp1[3]*100)) {
					$index = $j;
				}
			}			
			if ( $index != $i ) {
				$small = $localresults[$i];
				$localresults[$i]=$localresults[$index];
				$localresults[$index]=$small;
			}
		//echo $localresults[$i]."<br/>";
		}
		return $localresults;
	}
	
	function displayResults($localresults,$count){
       $total=0;
    // echo $localresults;
     //echo $count;
	   
	   if($count>count($localresults)){
			$count=count($localresults);
	   }	
		//Heading
		echo "<p align=center class=style3><b><u>SEARCH RESULTS:</b></u></p><br>";
		 echo "<table class=style3>";
        	echo "<tr><th><h4 align=center>BOOKNAME</h4></th>";
        	echo "<th><h4 align=center>AUTHOR</h4></th>";
        	echo "<th><h4 align=center>PRICE</h4></th></tr>";
        	
	
        while ($total<$count) {
            $rowresult = explode("|" , $localresults[$total]);
            echo "<tr><td>";
            echo $rowresult[0]." ";
            echo "</td><td>";
            echo $rowresult[1]." ";
            echo "</td><td>";
            echo $rowresult[2]." "."<br/>";
            echo "</td></tr>";
            $total++;
         }
         echo "</table>";
     

}
	
?>

