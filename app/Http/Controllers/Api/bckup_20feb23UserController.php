<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use DB;
use Mail;
use Log;
use Image;
use URL;
use JWTAuth;
use JWTFactory;
use Carbon\Carbon; 
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Input;
use App\Classes\ErrorsClass;
//use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{ 

  public function getuserDetails(Request $request, $id) {
    try{
      $isUser = User::find($id);
      if ($isUser) {
        $user = User::where('id', $id)->first()->toArray();
        $userdata = User::where('id', $id)->first();
        return response()->json(['status'=>true,'message'=>'User details','error'=>'','data'=>$user], 200);
      } else {
        return response()->json(['status'=>false,'message'=>'User not found','error'=>'','data'=>''], 400);
      }
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

public function checkuserlogin(Request $request) {
   try{
    $userid = $request->userid;
    $users = User::where('id', $userid)->where('logins', 0)->where('status', '=', '1')->where('isdeleted', '=', '0')->first();
    if($users){
      return response()->json(['status'=>true,'message'=>'Your account has been successfully created. Please provide information about your business now.','error'=>'','data'=>$users], 200);
    }
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
public function getuserRole(){
  try{
    $getuserRole = DB::table('roles')->select('*')->whereIn('id', [2, 5])->where('status', '=', '1')->where('deleted', '=', '0')->get();
    return response()->json(['status'=>true,'message'=>'list user role','error'=>'','data'=>$getuserRole], 200);
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
public function getOTPData(Request $request){
  try{
    $checkData = DB::table('otp_history')->where('phone_number', $request->phone_number)->where('status', '=', '1')->where('is_deleted', '=', '0')->first();
    if($checkData){
      return response()->json(['status'=>true,'message'=>'otp history data','error'=>'','data'=>$checkData], 200);
    } else {
      return response()->json(['status'=>true,'message'=>'otp history data not found','error'=>'','data'=>''], 200);
    }
    
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
public function ResetOTPData(Request $request){
  try{
    $checkData = DB::table('otp_history')->where('phone_number', $request->phone_number)->update(['otp'=> null]);
    if($checkData){
      return response()->json(['status'=>true,'message'=>'otp history data updated successfully!','error'=>'','data'=>''], 200);
    } else {
      return response()->json(['status'=>true,'message'=>'otp history data not updated successfully!','error'=>'','data'=>''], 200);
    }
    
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
public function SaveOTPNumber(Request $request){
  try{
    $encoded_otp_number = $request->otp_number;
    $encoded = base64_decode($encoded_otp_number);
    $decoded_otp_number = "";
    for($i = 0; $i < strlen($encoded); $i++) {
    $b = ord($encoded[$i]);
    $a = $b ^ 10; 
    $decoded_otp_number .= chr($a);
    }
    $new_decoded_otp_number = base64_decode($decoded_otp_number);
    $checkData = DB::table('otp_history')->where('phone_number', $request->phone_number)->where('status', '=', '1')->where('is_deleted', '=', '0')->first();
    if($checkData){
      $saveData = DB::table('otp_history')->where('phone_number', $request->phone_number)->where('status', '=', '1')->where('is_deleted', '=', '0')->update(['otp'=>$new_decoded_otp_number]);
    } else {
      $saveData = DB::table('otp_history')->insert(['phone_number'=>$request->phone_number, 'otp' => $new_decoded_otp_number]);
    }
    return response()->json(['status'=>true,'message'=>'list user role','error'=>'','data'=>'otp saved'], 200);
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
public function SendOTP(Request $request){
  try{
    $encoded_message_body = $request->message_body;
    $encoded = base64_decode($encoded_message_body);
    $decoded_message_body = "";
    for($i = 0; $i < strlen($encoded); $i++) {
    $b = ord($encoded[$i]);
    $a = $b ^ 10; 
    $decoded_message_body .= chr($a);
    }
    $new_decoded_message_body = base64_decode($decoded_message_body);
    $API_TOKEN = "nnado4rv-dnlvqqcr-s5f5eeix-xplhvac2-pe1ylizw";
    $SID = "UHL10666API";
    $DOMAIN = "https://smsplus.sslwireless.com";
    $msisdn = $request->phone_number;
    $messageBody = $new_decoded_message_body;
    $csmsId = $request->csms_id; // csms id must be unique
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
    return $response;
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
function RemoveSpecialChapr($string){
    $title = str_replace( array( '\'', '"', ',', ';', '<', '>', ':', '_', '-', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '+', '=', '.', '?', '/', '`', '|', '[', ']', '{', '}' ), '$', $string);
        return $title;
  }

public function guard()
{
  return Auth::guard();
}

}
