<?php
/* Remind to download and put files in https://github.com/weberhofer/jsonrpcphp at the good place */
require_once './jsonrpcphp/jsonRPCClient.php';

// include_once 'vendor/autoload.php';

// define( 'LS_BASEURL', 'https://survey.stsn-nci.ac.id/');  // adjust this one to your actual LimeSurvey URL
// define( 'LS_USER', 'kelompok3' );
// define( 'LS_PASSWORD', '123456' );

$rpcUrl="https://survey.stsn-nci.ac.id/index.php/admin/remotecontrol";
$rpcUser="kelompok3";
$rpcPassword="123456";

// the survey to process
$survey_id=798923;
$datatype = "pdf";
$fields = array(123,456);

$lsJSONRPCClient = new \org\jsonrpcphp\jsonRPCClient($rpcUrl);
$sessionKey= $lsJSONRPCClient->get_session_key($rpcUser,$rpcPassword );
//~ If an error happen
if(is_array($sessionKey))
{
    header("Content-type: application/json");
    echo json_encode($sessionKey);
    die();
}
$response=$lsJSONRPCClient->list_surveys($sessionKey);

// $tokens = $lsJSONRPCClient->activate_tokens($sessionKey, $survey_id, $fields);

// $answer = $lsJSONRPCClient->export_responses_by_token($sessionKey, 
//                         $survey_id, $datatype, "json", 1,
//                         null, $sCompletionStatus = 'all', 
//                         $sHeadingType = 'code', $sResponseType = 'short', 
//                         $fields);

// $export = $lsJSONRPCClient->export_responses($sessionKey, 
//                 $survey_id, 
//                 "json");

header("Content-type: application/json");
//~ For big array : base64 encoded
if(is_array($response)){
    echo json_encode($response);
    echo "\n\n";
    // echo json_encode($export);
    // echo "\n\n";
    // echo json_encode($answer);
} else {
    print_r(base64_decode($response), null );
}
//~ release the session key
$lsJSONRPCClient->release_session_key( $sessionKey );  
