<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;
use App\Models\HomeSetting;
use App\Models\Testimonials;
use App\Models\Doctors;
use App\Models\Publications;
use App\Models\Emergency;
use Log;
use DB;
use App\Classes\ErrorsClass;

class EmergencyController extends Controller
{

 public function SendEmergencySMS(Request $request){
  try{
    // $encoded_message_body = $request->message_body;
    // $encoded = base64_decode($encoded_message_body);
    // $decoded_message_body = "";
    // for($i = 0; $i < strlen($encoded); $i++) {
    // $b = ord($encoded[$i]);
    // $a = $b ^ 10; 
    // $decoded_message_body .= chr($a);
    // }
    $csms_generate_number = rand(555555,999999);
    $emergency_message = "Emergency Case \n" . "Name: " . $request['First_Name'] . " " . $request['Last_Name'] . "\n" . "Phone Number: " . $request['Phone_Number'] . "\nLink: " . $request['Patient_File_Link'] ;
    $new_decoded_message_body = base64_decode("Test");
    $API_TOKEN = "nnado4rv-dnlvqqcr-s5f5eeix-xplhvac2-pe1ylizw";
    $SID = "UHL10666API";
    $DOMAIN = "https://smsplus.sslwireless.com";
    $msisdn = '01757192483';
    $messageBody = "Dummy Text";
    $csmsId = $csms_generate_number; // csms id must be unique
    $params = [
        "api_token" => $API_TOKEN,
        "sid" => $SID,
        "msisdn" => $msisdn,
        "sms" => $messageBody,
        "csms_id" => $csmsId
    ];
    $url = trim($DOMAIN, '/')."/api/v3/send-sms";
    $params = json_encode($params);
    $ch = curl_init(); // Initialize cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($params),
        'accept:application/json'
    ));
    $response = curl_exec($ch);
    curl_close($ch);
    return $emergency_message;
  } catch(\Illuminate\Database\QueryException $e) {
    $errorClass = new ErrorsClass();
    $errors = $errorClass->saveErrors($e);
    return response()->json(['status'=>false,'message'=>'','error'=>'Sql query error','data'=>''], 401); 
  } catch(\Exception $e) {
    $errorClass = new ErrorsClass();
    $errors = $errorClass->saveErrors($e);
    return response()->json(['status'=>false,'message'=>'','error'=>'Undefined variable error','data'=>''], 401);
  }
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postEmergencyCase(Request $request)
    {
        //
    	// Log::info($request);
    	 $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'phoneNumber' => 'required|numeric',
            'address' => 'required_if:ambulanceService,true'
        ]);
    //   return $request->all();

        $emergency = Emergency::create([
        				'type'       => $request['ambulanceService'],
        				'first_name' => $request['firstName'],
        				'last_name' => $request['lastName'],
        				'phone_number' => $request['phoneNumber'],
        				'address' => $request['address'],
        				'patient_file_link' => $request['document']
        			]);
        $notificationSMS = ""; 
        if ($request['Type'] == "Home") {
        	$notificationSMS = "01757192483";
        } elseif ($request['Type'] == "Ambulance") {
        	$notificationSMS = "01757192482";
        } elseif ($request['Type'] == "Hospital") {
        	$notificationSMS = "01757192484";
        };
        $notificationData = [
    						'Type'       => $request['Type'],
	        				'First Name' => $request['First_Name'],
	        				'Last Name' => $request['Last_Name'],
	        				'Phone Number' => $request['Phone_Number'],
	        				'Address' => $request['Address'],
	        				'Patient File Link' => $request['Patient_File_Link'],
	        				'Notification SMS'  => $notificationSMS
        					];
        $sms = $this->SendEmergencySMS($request);
        Log::info($sms);
        return [
            "status" => 1,
            "data" => $emergency,
            "sms" => $notificationData
        ];
    }
 
}