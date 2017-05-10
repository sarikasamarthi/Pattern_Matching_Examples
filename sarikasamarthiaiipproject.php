<!--PROGRAM TO IMPLEMENT DATA EXTRACTION FROM WEBSITE USING CURL,DOMDocument AND DOMXpath.Used simple style sheet for displaying.The user entered text is passed to the website and using curl the data from that particular website is extracted and passed to HTML Parser,using DOMXpath query extracted required data from the website.My project is focused on extraction book details from the website like NAME,AUTHOR,PRICE.Done ranking the display results based on price.Displayed the results using simple table jsut for clean look.-->
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
			//$input varaible holds keyword entered by the user on the HTML page
			$input=$_POST['input'];
			//Simple validation when the user submits the HTML page without entering anything
			if(empty($input) === true){
						echo "PLEASE ENTER KEYWORD";
			}
	
      		//$input="java";
			//Simple Book Website used for this project to extract data like BOOK NAME,AUTHOR and PRICE.The Keyword entered by user is passed to this website
			$url = "http://www.powells.com/s?kw=".$input . "&class=";

            //Website is passed to CURL,WHERE IT IS INITIATED AND THE WHOLE HTML PAGE IS IN CURLVARIABLE.
	 		$curlhandle = curl_init($url);
			//BUNCH OF CURL OPTIONS 
        	curl_setopt($curlhandle, CURLOPT_RETURNTRANSFER, true);
        	curl_setopt($curlhandle, CURLOPT_BINARYTRANSFER, true);
	 		curl_setopt($curlhandle,CURLOPT_HEADER,0);
	 		curl_setopt($curlhandle,CURLOPT_TIMEOUT,5);
    		//CURL IS EXECUTE AND THE WHOLE HTML PAGE IS IN RESULT VARIABLE
	 		$result = curl_exec($curlhandle);
	  		//CURL IS CLOSED
	 		curl_close($curlhandle);

			//CURL RESULT IS PASSED TO DOMDocument A HTML PARSER.THE HTML page is loaded USING loadHTML()method.
	 		$dom = new DOMDocument;
     		$dom->loadHTML($result);	
     		//echo $powells_dom->saveHTML();
			
			//DOMXpath is used to query the required data with the HTML tags.Directly going to that particular tag to extract data.
     		$xpath = new DOMXpath($dom);
			//booktitle holds the value in h3 tag of class=book-title
    		$booktitle = $xpath->query("//h3[@class='book-title']");
    		//print_r($title_data);
			//bookauthor holds the value author that is in cite tag
    		$bookauthor = $xpath->query("/html/body/div/table/tr/td/ol/li/div/div/cite");
			//bookprice holds the value of book price in the tag big with class=price
    		$bookprice = $xpath->query("//big[@class='price']");

			//All the book details is passed to USer Defined function to extract all the search results of each book 
    		$bookresults  = parseData($booktitle,$bookauthor,$bookprice);
			//echo$bookresults;
			//After extraction of book details,it is ranked based on price of each book
    		$bookresults = sortBookPrice($bookresults);
			//echo $bookresults;
	
			$finalresults;
			$count = 0;
			//Since Extraction is performed for one site,The below for loop is useful if extracting from different websites and then finally sorting all the results
			for($i = 0; $i <count($bookresults);$i++){
					$finalresults[$count++] =  $bookresults[$i];
			}	
		
			$finalresults = sortBookPrice($finalresults);
			//echo $finalresults."<br/>";
			//Limiting number of rows of search results to 40
       		$limit=40;
			//Display function to display results
			displayResults($finalresults,$limit);
       		//echo $finalresults."<br/>";
  			//End of program
       		exit(0);

			/*parseData userdefined function extracts books details like BOOKNAME,BOOKAUTHOR,BOOKPRICE from all the search books.Basically it is looped through all the results and extracting NODE by NODE.FOR PRICE in this particular site the values are in two tags,so did some comparisons.All the values are stored in a variable seperated by a delimiter |*/
			function parseData($booktitle,$bookauthor,$bookprice) {
	   
	   					$bookresults = array();
          				$i = 0;
	  				    $j= 0;

	   					while($i< $booktitle->length){
				
            							$title = $booktitle->item($i);
										$author= $bookauthor->item($i);
										$price = $bookprice->item($i);

		   								if(strcmp($title->nodeValue, "") != 0 && strcmp($author->nodeValue, "") != 0 && strcmp($price->nodeValue, "") != 0){							
															//Extraction of dollar symbols to do comparison
															$firstdollar  = strpos($price->nodeValue, "$");
															$seconddollar = strripos($price->nodeValue, "$");
				
															if($seconddollar > $firstdollar)	{
																			$absolutePrice = substr($price->nodeValue, $firstdollar + 1, $seconddollar - 1);
																			$price->nodeValue = substr($price->nodeValue, $firstdollar, $seconddollar);
															}else{
																			$absolutePrice = substr($price->nodeValue, $dollarIndex + 1);
															 }
				 
														    $bookresults[$j] = $title->nodeValue . "|" . $author->nodeValue . "|" . $price->nodeValue."|".$absolutePrice;
															//echo $bookresults[$j]."<br/>";
															$j++;
										}
           							    $i++;
        				 }
		 				return $bookresults;
   			}
	
			/*sortBookPrice user defined function performs sorting based on price.Used SELECTION SORT ALGORITHM to implement search.Since each row contains bookname,author along with price and it is seperated by delimiter |.The third field contains price with cents.Chaned to absolute value to do comparisions.*/
   			function sortBookPrice($localresults)	{
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
			
			/*displayResults function displays the results in aq tabular form.If serach result count exceed the count specified in the program,it is set to specified count*/
	
			function displayResults($localresults,$count){
       						$total=0;
    						// echo $localresults;
     						//echo $count;
	   
	  						 if($count>count($localresults)){
										$count=count($localresults);
	   						 }	
		
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

