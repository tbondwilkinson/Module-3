<?php
function abbreviate($input,$width) {
	if(empty($input)) return $input;

	if (strlen($input) <= $width) {
	    return $input;
	}

	$output = substr($input,0,$width);

	//normals words are seldom more than 30 chars
	$pos = 0;
	$found = false;

	for($i = $width ; $i >= 0 ; $i--) {
	     if(ctype_space($output[$i])) {
	        $found = true;
	        break;
	     }
	     $pos++;
	}

	if($found && ($pos > 0)) {
	    $output = substr($output,0,($width-$pos));
	    $output = rtrim($output);
	}

	$output .= '...';
	return $output;
}
?>