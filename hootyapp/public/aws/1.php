<?php
	
 
	$con=($GLOBALS["___mysqli_ston"] = mysqli_connect('localhost', 'app_hooty', 'default@123'));
   	if(!$con)
   	{
       die('could not connect'.((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
   	}

	((bool)mysqli_query($con, "USE app_hooty"));




 
?>

<?
//////
//// CONFIGURATION
//////
//For Debugging.
$logToFile = true;
//Should you need to check that your messages are coming from the correct topicArn
$restrictByTopic =true;
$allowedTopic = "arn:aws:sns:us-west-2:281644103958:hooty";
//$allowedTopic = "arn:aws:sns:eu-west-1:280366171354:hotel";
//For security you can (should) validate the certificate, this does add an additional time demand on the system.
//NOTE: This also checks the origin of the certificate to ensure messages are signed by the AWS SNS SERVICE.
//Since the allowed topicArn is part of the validation data, this ensures that your request originated from
//the service, not somewhere else, and is from the topic you think it is, not something spoofed.
$verifyCertificate = true;
$sourceDomain = "sns.us-west-2.amazonaws.com";
 
//////
//// OPERATION
//////
$signatureValid = false;
$safeToProcess = true; //Are Security Criteria Set Above Met? Changed programmatically to false on any security failure.
if($logToFile){
	////LOG TO FILE:
	
	$dateString = date("Ymdhis");
	$dateString = $dateString."_r.txt";
	$dateString = "11_r.txt";
	$myFile = $dateString;
	$fh = fopen($myFile, 'w') or die("Log File Cannot Be Opened.");
}
//Get the raw post data from the request. This is the best-practice method as it does not rely on special php.ini directives
//like $HTTP_RAW_POST_DATA. Amazon SNS sends a JSON object as part of the raw post body.
$json = json_decode(file_get_contents("php://input"));
//Check for Restrict By Topic
if($restrictByTopic){
	if($allowedTopic != $json->TopicArn){
		$safeToProcess = false;
		if($logToFile){
			fwrite($fh, "ERROR: Allowed Topic ARN: ".$allowedTopic." DOES NOT MATCH Calling Topic ARN: ". $json->TopicArn . "\n");
		}
	}
}
//Check for Verify Certificate
if($verifyCertificate){
	//Check For Certificate Source
	$domain = getDomainFromUrl($json->SigningCertURL);
	if($domain != $sourceDomain){
		$safeToProcess = false;
		if($logToFile){
			fwrite($fh, "Key domain: " . $domain . " is not equal to allowed source domain:" .$sourceDomain. "\n");
		}
	}
	
	
	
	//Build Up The String That Was Originally Encoded With The AWS Key So You Can Validate It Against Its Signature.
	if($json->Type == "SubscriptionConfirmation"){
		$validationString = "";
		$validationString .= "Message\n";
		$validationString .= $json->Message . "\n";
		$validationString .= "MessageId\n";
		$validationString .= $json->MessageId . "\n";
		$validationString .= "SubscribeURL\n";
		$validationString .= $json->SubscribeURL . "\n";
		$validationString .= "Timestamp\n";
		$validationString .= $json->Timestamp . "\n";
		$validationString .= "Token\n";
		$validationString .= $json->Token . "\n";
		$validationString .= "TopicArn\n";
		$validationString .= $json->TopicArn . "\n";
		$validationString .= "Type\n";
		$validationString .= $json->Type . "\n";
	}else{
		$validationString = "";
		$validationString .= "Message\n";
		$validationString .= $json->Message . "\n";
		$validationString .= "MessageId\n";
		$validationString .= $json->MessageId . "\n";
		if($json->Subject != ""){
			$validationString .= "Subject\n";
			$validationString .= $json->Subject . "\n";
		}
		$validationString .= "Timestamp\n";
		$validationString .= $json->Timestamp . "\n";
		$validationString .= "TopicArn\n";
		$validationString .= $json->TopicArn . "\n";
		$validationString .= "Type\n";
		$validationString .= $json->Type . "\n";
	}
	if($logToFile){
		fwrite($fh, "Data Validation String:");
		fwrite($fh, $validationString);
	}
	
	$signatureValid = validateCertificate($json->SigningCertURL, $json->Signature, $validationString);
	
	if(!$signatureValid){
		$safeToProcess = false;
		if($logToFile){
			fwrite($fh, "Data and Signature Do No Match Certificate or Certificate Error.\n");
		}
	}else{
		if($logToFile){
			fwrite($fh, "Data Validated Against Certificate.\n");
		}
	}
}
if($safeToProcess){
	//Handle A Subscription Request Programmatically
	if($json->Type == "SubscriptionConfirmation"){
		//RESPOND TO SUBSCRIPTION NOTIFICATION BY CALLING THE URL
		
		if($logToFile){
			fwrite($fh, $json->SubscribeURL);
		}
		
		$curl_handle=curl_init();
		curl_setopt($curl_handle,CURLOPT_URL,$json->SubscribeURL);
		curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
		curl_exec($curl_handle);
		curl_close($curl_handle);	
	}
	
	
	//Handle a Notification Programmatically
	if($json->Type == "Notification"){
		//Do what you want with the data here.
		$aaa=json_decode($json->Message,true);
		fwrite($fh, '=========================');
		fwrite($fh, $aaa['eventType']);
		$rrr=mysqli_query($con,"Select * from chat_logs where msg_id='".$aaa['mail']['messageId']."'");
			$row=mysqli_fetch_array($rrr);
			//$cli=$row['Click'] + 1;
		fwrite($fh, $row);


		if($aaa['eventType']=='Click')
		{	
			$rrr=mysqli_query($con,"Select * from chat_logs where msg_id='".$aaa['mail']['messageId']."'");
			$row=mysqli_fetch_array($rrr);
			$cli=$row['Click'] + 1;
		 
			echo $query ="update chat_logs set Click ='".$cli."' where msg_id='".$aaa['mail']['messageId']."'";
			mysqli_query($con,$query) or die("failed".mysqli_error());
		}
		if($aaa['eventType']=='Open')
		{	
			$rrr=mysqli_query($con,"Select * from chat_logs where msg_id='".$aaa['mail']['messageId']."'");
			$row=mysqli_fetch_array($rrr);
			$cli1=$row['Open'] + 1;
		 
			echo $query1 ="update chat_logs set Open ='".$cli1."' where msg_id='".$aaa['mail']['messageId']."'";
			mysqli_query($con,$query1) or die("failed".mysqli_error());
		}

		if($aaa['eventType']=='Bounce')
		{	
			$rrr=mysqli_query($con,"Select * from chat_logs where msg_id='".$aaa['mail']['messageId']."'");
			$row=mysqli_fetch_array($rrr);
			$cli1=$row['Bounce'] + 1;
		 
			echo $query1 ="update chat_logs set Bounce ='".$cli1."' where msg_id='".$aaa['mail']['messageId']."'";
			mysqli_query($con,$query1) or die("failed".mysqli_error());
		}

		if($aaa['eventType']=='Delivery')
		{	
			$rrr=mysqli_query($con,"Select * from chat_logs where msg_id='".$aaa['mail']['messageId']."'");
			$row=mysqli_fetch_array($rrr);
			$cli1=$row['Delivery'] + 1;
		 
			echo $query1 ="update chat_logs set Delivery ='".$cli1."' where msg_id='".$aaa['mail']['messageId']."'";
			mysqli_query($con,$query1) or die("failed".mysqli_error());
		}

		if($aaa['eventType']=='Reject')
		{	
			$rrr=mysqli_query($con,"Select * from chat_logs where msg_id='".$aaa['mail']['messageId']."'");
			$row=mysqli_fetch_array($rrr);
			$cli1=$row['Reject'] + 1;
		 
			echo $query1 ="update chat_logs set Reject ='".$cli1."' where msg_id='".$aaa['mail']['messageId']."'";
			mysqli_query($con,$query1) or die("failed".mysqli_error());
		}

		if($aaa['eventType']=='Send')
		{	
			$rrr=mysqli_query($con,"Select * from chat_logs where msg_id='".$aaa['mail']['messageId']."'");
			$row=mysqli_fetch_array($rrr);
			$cli1=$row['Send'] + 1;
		 
			echo $query1 ="update chat_logs set Send ='".$cli1."' where msg_id='".$aaa['mail']['messageId']."'";
			mysqli_query($con,$query1) or die("failed".mysqli_error());
		}
		/*fwrite($fh, '=========================');
		fwrite($fh, $aaa['mail']['destination'][0]);
		fwrite($fh, $query);
		fwrite($fh, '=========================');

		fwrite($fh, $json->Subject);
		fwrite($fh, $json->Message);*/
	}
}
//Clean Up For Debugging.
if($logToFile){
	ob_start();
	print_r( $json );
	$output = ob_get_clean();
	fwrite($fh, $output);
	////WRITE LOG
	fclose($fh);
}
//A Function that takes the key file, signature, and signed data and tells us if it all matches.
function validateCertificate($keyFileURL, $signatureString, $data){
	
	$signature = base64_decode($signatureString);
	
	
	// fetch certificate from file and ready it
	$fp = fopen($keyFileURL, "r");
	$cert = fread($fp, 8192);
	fclose($fp);
	
	$pubkeyid = openssl_get_publickey($cert);
	
	$ok = openssl_verify($data, $signature, $pubkeyid, OPENSSL_ALGO_SHA1);
	
	
	if ($ok == 1) {
	    return true;
	} elseif ($ok == 0) {
	    return false;
	    
	} else {
	    return false;
	}	
}
//A Function that takes a URL String and returns the domain portion only
function getDomainFromUrl($urlString){
	$domain = "";
	$urlArray = parse_url($urlString);
	
	if($urlArray == false){
		$domain = "ERROR";
	}else{
		$domain = $urlArray['host'];
	}
	
	return $domain;
}
echo "Private Function.";
?>