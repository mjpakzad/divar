<?php
function send_sms($numbers, $message)
{
    ini_set("soap.wsdl_cache_enabled", "0");
    $sms_client = new SoapClient('http://payamak-service.ir/SendService.svc?wsdl', array('encoding'=>'UTF-8'));
    
    try {
    	$parameters['userName']         = "lavasani980";
    	$parameters['password']         = "111649";
    	$parameters['fromNumber']       = "10009369216259";
    	$parameters['toNumbers']        = is_array($numbers) ? $numbers : [$numbers];
    	$parameters['messageContent']   = $message;
    	$parameters['isFlash']          = false;
    	$recId                          = array(0);
    	$status                         = 0x0;
    	$parameters['recId']            = &$recId ;
    	$parameters['status']           = &$status ;
    	echo $sms_client->SendSMS($parameters)->SendSMSResult;
    } 
    catch (Exception $e) 
    {
    	echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}