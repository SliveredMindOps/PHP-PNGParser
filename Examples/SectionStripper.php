<?php

require_once('../PNGParser.php');

/*
  CLI example for removing unneeded chunks from png files.

  greetings @ tobi&seb
*/


if(count($argv) < 2){
	echo "Not enough parameters given. The correct syntax is php SectionStripper.php FILEPATH\n";
	return;
}

//load file
$path = $argv[1];
$img = SliveredMindOps\PNGParser\PNGImage::fromFile($path);

if($img === NULL){
	echo "Unable to open stream for file '" . $path . "'. Exiting.\n";
	return;
}

$redundant_chunks = [];

//remove all unused chunks
for ($i=0; $i < count($img->chunks); $i++) { 
	switch ($img->chunks[$i]->type) {
		case 'tEXt':
		case 'zTXt':
		case 'iTXt':
		case 'tIME':
			array_push($redundant_chunks, $i);
		default:
			echo "Found " . $img->chunks[$i]->type . "\n";
			break;
	}
}

//reverse the array to be able to remove the each chunk without changing the order
$redundant_chunks = array_reverse($redundant_chunks);

for ($i=0; $i < count($redundant_chunks); $i++) {
	$idx = $redundant_chunks[$i];
	array_splice($img->chunks, $idx, 1);
}

echo "Removed " . count($redundant_chunks) . " chunks.\n";

//write out
$img->write("stripped".$path);
$img->dispose();
echo "Done\n";