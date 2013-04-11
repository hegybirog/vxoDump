<?php
	include("vxodump_helper.php");

	$array = array(
			 "var_1" => "val_1"
			,"var_2" => "val_2"
			,"var_3" => "val_3"
			,"var_4" => array("one","two","tree",false,(int)1,(float)12.324234,"1")
			,"var_5" => "This is the string."
			,"var_6" => "val_6"
			);

	$object 	= (object)$array;

	//USAGE
	vxoDump::dump($object);
?>

Some html code...