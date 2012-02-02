<?php

/*
   Generates a random password
   @author Sildaekar Decrura <admin@rejectedfreaks.net>
   @since 2007-07-26

   @return string Returns random password
*/
function genpass()
{
	$pass = "aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789!@$%&()+";
	srand((double)microtime() * 1000000);
	$i = 0;
	while ($i <= 7) {
		$num = rand() % 33;
		$tmp = substr($pass, $num, 1);
		$pass = $pass . $tmp;
		$i++;
	}
	return $pass;
}

/*
   Prepare an array to be added into the database
   @author Sildaekar Decrura <admin@rejectedfreaks.net>
   @since 2010-10-09

   @return string Returns prepared array
*/
function prep_array($array,$i=false,$ht=1, $escape=1)
{
	foreach($array as $value){
		$value=prep($value,$ht,$escape);
		$newarray[]=$value;
	}
	if($i){
		$newarray=implode(",",$newarray);
	}
	return $newarray;
}
/*
   Prepare a string to be added into the database
   @author Sildaekar Decrura <admin@rejectedfreaks.net>
   @since 2007-07-26

   @return string Returns prepared string
*/
function prep($string, $ht = true, $escape = true)
{
	//$tags = array("<b>", "</b>", "<i>", "</i>", "<u>", "<style>", "</style>", "</u>", "<s>", "</s>", "<img"); //Allowed Tags
	// $string = trim($string);
	// $string = strip_tags($string, $tags);
	$string = preg_replace("/&lt;/", "<", $string);
	$string = preg_replace("/&lt;/", "<", $string);
	$string = preg_replace("/<scr/", "&lt;sc", $string);
	$string = preg_replace("/<\/scr/", "&lt;/sc", $string);
	$string = preg_replace("/<iframe/", "&lt;iframe", $string);
	$string = preg_replace("/<\/iframe/", "&lt;/iframe", $string);
	$string = preg_replace("/<meta/", "&lt;meta", $string);

	if ($ht) {
		$string = preg_replace("/\n/", "<br>", $string);
	}
	if ($escape) {
		$string = addslashes($string);
	}
	return $string;
}
?>