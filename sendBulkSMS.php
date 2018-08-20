<?php
// CM 180820 This is a PHP script which will do the following:
// Reads mobile number from file "numbers.txt"
// Reads text message from "message.txt"
// Sends a text message to each number using sendmode.com API
// The user will create "numbers.txt" and "message.txt"
// Script is executed from bash with command:
// php sendBulkSMS.php

$currTime = date('Y-m-d H:i:s');
$logFile = '/var/log/sms.log';
$sms_username = "c.maverley@permanet.ie";
$sms_password = "XXXXXXXX";
$senderid = "permaNET.ie";
$message = file_get_contents("message.txt");
$message = str_replace("\r", "\n", $message);

// CM Iterate through $numbers
$handle = fopen("numbers.txt", "r");
if ($handle) {
	while (($mobilenumber = fgets($handle)) !== false) {
		$mobilenumber = trim(preg_replace('/\s\s+/', ' ', $mobilenumber));   // Removes \n from the string
		//echo json_encode(htmlspecialchars($mobilenumber));
		$logMessage = $currTime . "\t" . $mobilenumber . "\t" . $message;
		echo $logMessage;	
		$url = "https://api.sendmode.com/httppost.aspx?Type=sendparam&username=".urlencode($sms_username)."&password=".urlencode($sms_password)."&numto=".urlencode($mobilenumber)."&data1=".urlencode($message)."&senderid=".urlencode($senderid);
		//pr($url) ; die;
		$reply = file_get_contents($url);
		$reply_data = simplexml_load_string($reply);
		$val=$reply_data->call_result->result;
		//echo $val;

		// Write to log
        	echo file_put_contents("/var/log/sms.log",$logMessage,FILE_APPEND);	
	}	
	fclose($handle);
} else {
    // error opening the file.
}
?>
