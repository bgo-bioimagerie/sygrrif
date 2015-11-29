<?php

function monthShortNames($monthInt){
	
	$month[1] = "Jan.";
	$month[2] = "Feb.";
	$month[3] = "Mar.";
	$month[4] = "Apr.";
	$month[5] = "May.";
	$month[6] = "Jun.";
	$month[7] = "Jul.";
	$month[8] = "Aug.";
	$month[9] = "Sep.";
	$month[10] = "Oct.";
	$month[11] = "Nov.";
	$month[12] = "Dec.";
	
	return $month[$monthInt];
	
}

?>