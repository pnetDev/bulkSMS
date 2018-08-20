<?PHP

$sms_username = "c.maverley@permanet.ie";
$sms_password = "perma0108";
$senderid = "permaNET.ie";

// These are the files the user generates.
$file_handle = fopen("numbers.txt", "rb");
$message = file_get_contents("message.txt");
$message = str_replace("\r", "\n", $message);
// Sample code
// $homepage = file_get_contents('http://www.example.com/');
// echo $homepage;



while (!feof($file_handle) ) {
	$mobilenumber = fgets($file_handle);
	$mobilenumber = str_replace("\r", "\n", $mobilenumber);
	// echo $mobilenumber;
	// print "Sending $message to $mobilenumber";
	$url = "https://api.sendmode.com/httppost.aspx?Type=sendparam&username=".urlencode($sms_username)."&password=".urlencode($sms_password)."&numto=".urlencode($mobilenumber)."&data1=".urlencode($message)."&senderid=".urlencode($senderid);
 	// pr($url) ; die;
	echo $url;
        echo "";
	$reply = file_get_contents($url);
	$reply_data = simplexml_load_string($reply);
	$val=$reply_data->call_result->result;
	echo $val;
	}
fclose($file_handle);

?>
