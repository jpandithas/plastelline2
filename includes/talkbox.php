<?php 
include ("settings/settings.php");
function talkbox() {
global $t_content; 
global $home_scr; 
global $database;
global $db_user;
global $db_pass;
$talkbox=$_POST['talkbox']; //acquire data from post
$say=$_POST['Say'];
if ($say=='Say') {
	if ($talkbox=='') {
	
	$phrase[0]="Y U NO Speak?";
	$phrase[1]="Stop Poking Me!";
	$phrase[2]="Seriously, I am Awake! You dont have to test me!";
	$phrase[3]="It is:".date('l jS \of F Y h:i:s A').". Happy?"; 
	
	$number=rand(0,3);
	
	$t_content="<b>You said:</b> nothing! <br>$phrase[$number]";}
	else  {
	$t_content="<b>You said:</b> <table border='0' width='200px'><tr><td><pre>$talkbox</pre></td></tr></table> But this is what makes sense to me:<br>"; 
	
	$talkbox=preg_replace('/[^a-z0-9]/i', ' ', $talkbox); // regex to remove everything that is different than a to z and 0 to 9
	$talkbox=trim(preg_replace( '/\s+/', ' ', $talkbox)); // regex to remove exempt spaces
	$text_array=explode(" ",$talkbox);
	//$text_array=array_unique($text_array);
	$i=0;
	$j=0;
	$l=0;
	$dubl=0;
	$sum=0;
	$id_exists=0;
	
	 foreach ($text_array as $key => $value) {
		$value=strtolower($value); 
		//$sql="Select tier_id, reference_wordname, reference_id, wordgroup from layer1 where wordname='$value'";
		//$data=sendquery($sql);
     
        //far safer option in using PDO where the input is parametrized and not placed literally in the query 
         try {
      $conn = new PDO("mysql:host=localhost;dbname=$database", $db_user, $db_pass); //create a new instance of the PDO class for connection 
      $stmt = $conn->prepare('Select tier_id, reference_wordname, reference_id, wordgroup from layer1 where wordname= :name'); //Prepare the query 
      $stmt->bindParam(':name', $value); //bind the paramaters from the user data (var) to the query
      $stmt->execute(); //execute not SEND the query ->it has been prepared
      $data = $stmt->fetch(); // get the row of data returned 
	  $conn=null; // close the connection to save resources 
           } catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage(); }
         
		
		//echo mysql_error();
		$tier=$data['tier_id'];
			 if ($tier==null) {$tier=5;} else {settype($tier,"Integer");} // if the tier is empty set it to level 5, else make the tier integer
		 $reference=$data['reference_wordname'];
		 $reference_id=$data['reference_id'];
		 $wordgroup=$data['wordgroup'];
		 if ($reference!=null) { $value=$reference; $tier=$reference_id;} // synonym check
		 $newstring[$i]=array($value,$tier,$key); 
		 if ($wordgroup>0) {$word_relation[$j]=$wordgroup; $sum+=$wordgroup; $j++;} // if a word belongs to a group add the entry and sum of group numbers 
		 for ($l=0;$l<=$i-1;$l++) {
		  if ($newstring[$i]['0']==$newstring[$l]['0']) {unset ($newstring[$i]); $duplicates[$dubl]=$i;  $dubl++;} }
	     $t_content.="Word in position [$key] is: [$value] with importance tier '$tier' and reference: '$reference' - group: $wordgroup</br>";
		 $i++;
	    }
		// find id trigger and value
		$id_value=0;
	 for ($j=0;$j<=$i;$j++) {
		  $word=$newstring[$j]['0'];
	      if ($word=='id') {$id_exists=1;} //id trigger
		  if ((is_numeric($word)) and ($word>0)) {$id_value=$word;}
	      } 
		  if ($id_value==0) {$id_exists=0;} //do not issue id if number is not present in text
		//echo "<pre>";
		//print_r($duplicates);
		//echo "</pre>";
		$duplicates_number=array_unique($duplicates,SORT_NUMERIC);
		$duplicates_nr=count($duplicates_number);
		$t_content.="<br>Word sum is $sum and found $j group entries of which $duplicates_nr duplicate(s) found<br>";
	     
				 
		 for ($k=0; $k<=$i; $k++) {
		    $tier=$newstring[$k]['1'];
			//echo $tier;
			if ($tier==1) {$tierones++;} else if ($tier==2) {$tiertwos++;} else if ($tier==5) {$tierfives++;} //added tier five accumulation
		   }
		 //check tiers and data corellation
		 if (($tierones>1) or ($tiertwos>1)) {$undecided=1;}
		 if (($tierones<1) and ($tiertwos<1) and ($tierfives>0)) {$undecided=2;}
		 if (($tierones<1) and ($tiertwos==1)) {$undecided=3;}
		 // add here the possibility of tierones without having tiertwos and vice versa
         
		 $word_entities=array_unique($word_relation, SORT_NUMERIC); // takes the unique entries of an array and deprecates the rest
		 foreach ($word_entities as $key => $value) {
		  
		  if ($sum % $value) { $coherence=0;} else { $coherence=1;}
				 }
		 $t_content.="Word Coherence is: $coherence <br>";
		 // end check 
		 
		  $t_content.="<br>However, what you meant was: ";
		 
		 for ($j=0; $j<=$i; $j++) {
		    $text=$newstring[$j]['0'];
			$t_content.="$text ";
		   }
			if ($undecided==1) { if ($coherence==0) {$message=" and Incoherent!";} 
			                     $t_content.=" Which is ambiguous $message. Make up your mind!";} 
			  else if ($undecided==2) {
			         $t_content.="<br> You are in the mood for chat..";
					 } //end else for undecided 2
			  else if ($coherence==0) { $t_content.="<br>Incoherent information!<br>";} 
		      else if ($undecided==3) {$t_content.="<br>Incomplete Command!";}
			  else {
			    for ($k=0; $k<=$i; $k++) {
		        $tier=$newstring[$k]['1'];
		 	    if ($tier==1) {$action_link="action=".$newstring[$k]['0'];}
			    if ($tier==2) {$type_link="&type=".$newstring[$k]['0'];}
		        }// end loop
			    for ($k=0; $k<=$i; $k++) {
		        $word=$newstring[$k]['0'];
		 	    if ((($word=='edit') or ($word=='display') or ($word=='delete')) and ($id_exists=='1')) {$id_link="&id=".$id_value;}
		        }
			$t_content.="<br>What I can really do for you is: <em><b> $action_link $type_link </b></em>";
			$t_content.="<br><br>Link: <a class='button-link' href='$home_scr/index.php?$action_link$type_link$id_link'>Click Here!</a>";
			}// end for the else for the undecided 
	}
	
} 

$form = "<span id='sidebar-header'> <b>Talkbox &reg</b> </span>";
$form .= "<form action='' method='POST'>";
$form .= "<input name='talkbox' type='text' size='20'>";
$form .="<input type='submit' value='Say' name='Say'>";
$form .="</form>";
echo $form; 
}


?>