<?php
$handle = fopen("numbers.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
	print "Sending text to $line";
    }

    fclose($handle);
} else {
    // error opening the file.
} 
?>
