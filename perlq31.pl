#!/usr/bin/perl/

#INPUT FILE
open(INPUT_FILE,"<question3input.txt") or die "cannot open file";

#OUTPUT FILE
open(OUTPUT_FILE,"+>question3output.txt") or die "cannot open file";

#READ THE INPUT FILE AND STORE IN THE VARIABLE
while($post=<INPUT_FILE>){

		#SPLIT THE DATA INTO WORDS AND STORE IN ARRAY 
 		@lines=split / /,$post;

		#READ EACH ELEMENT IN THE ARRAY
 		foreach $line (@lines) {
  				#print $line;

				#REGULAR EXPRESSION FOR EMAILID EXTRACTION
  				if($line =~ /[\w]+@[\w\.]+/) {
					print $line;
   					print OUTPUT_FILE $line;
					
  				}

				#REPLACE THE ARRAY ELEMENT 'STUDENT' WITH 'SPACE'
 				$line =~ s/student//;

				#REPLACE THE ARRAY ELEMENT WITH ',' WITH 'SPACE'
       			$line =~ s/\,//;

				#REPLACE THE ARRAY ELEMENT 'EMAILID' WITH 'SPACE'
				$line =~ s/[\w]*@[\w\.]*//;

				#REPLACE 'NETID' WITH 'SPACE'
				if($line =~ /..[[\d]+/){
						$line =~ s/..[\d]+//g;
		
				}

				#ADD '_' TO LEFT OVER NAMES IN THE ARRAY
       			$line =~ s/([\w]+)/$1_/;
				#print $line;

				#REPLACE ONE EXTRA '_' AT THE END WITH 'SPACE'
				$line =~ s/[\_]+[\s]+$//g;
				print $line;
				print OUTPUT_FILE $line;
       			
 		}

}
close INPUT_FILE;
close OUTPUT_FILE;