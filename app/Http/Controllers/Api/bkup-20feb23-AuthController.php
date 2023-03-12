<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use App\Models\User;
//use App\Models\Loginhistory;
use DB;
use Mail;
use Log;
use Image;
use URL;
use JWTAuth;
use JWTFactory;
use Carbon\Carbon; 
use Session;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Input;
use App\Classes\ErrorsClass;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{

  public function register(Request $request){

    try{
        $rules = [
            // 'username' => 'unique:users',
            'email' => 'unique:users',
        ];
        $messages = [
            // 'username.unique'   =>  'That user name is already in use.',
             'email.unique'   =>  'That email address is already in use.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) 
        { 
            return response()->json(['status'=>false,'message'=>'Email address already in use','error'=>$validator->errors(),'data'=>'']);
        }
        $u_device = '';
        if($this->isMobile()){
           $u_device = 'mobile';
        }
        else {
           $u_device = 'desktop';
        }
        $Input =  [];
        $Input['username'] = trim($request->email);
        $Input['email'] = trim($request->email);
        $Input['password'] = trim(Hash::make($request->password));
        $Input['hdpwd'] = trim($request->password);
        $Input['firstname'] = ucfirst(trim($request->firstname));
        $Input['lastname'] = ucfirst(trim($request->lastname));
        $Input['fullname'] = ucfirst(trim($request->firstname)).' '.ucfirst(trim($request->lastname));
        $Input['phone'] = '';
        $Input['address_line_1'] = '';
        $Input['address_line_2'] = '';
        $Input['city'] = '';
        $Input['state'] = '';
        $Input['country'] = '';
        $Input['zipcode'] = '';
        $Input['profilepic'] = '';
        $Input['role'] = trim($request->role);
        //$Input['device'] = isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : null;
        $Input['device'] = $u_device;
        $Input['browser'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
        $Input['ipaddress'] = isset($_SERVER['REMOTE_ADDR']) ? ip2long($_SERVER['REMOTE_ADDR']) : null;
        $Input['active_code'] = strtolower(Str::random(30));
        $Input['isonline'] = '0';
        $Input['llhid'] = '0';
        $Input['number_of_locations'] = '';
        $Input['item_qnty'] = '';
        $Input['total_sum'] = '';
        $Input['sc_emsg'] = "Thank you so much for your kind words. We really appreciate it and would love for others to read it too. Help us out by making your review go live on Google!";
        $Input['sc_ebtnclr'] = '#333';
        $Input['sc_enote'] = "Thanks again for taking the time and effort to make sure your kind words are live on Google. It really means a lot to us and we thank you for your patronage. See you soon!";
        $Input['unsc_emsg'] = "Thank you very much for your honest feedback. We're so sorry to hear that you were not 100% satisfied at our business. Customer satisfaction is so important to us and we'd love the opportunity to improve. Please contact us during our regular business hours so we can assist you in any way. We sincerely thank you once again for your patronage. Have a wonderful day!";
        $Input['customer_id'] = '';
        $Input['subscription_id'] = '';
        $Input['plan_id'] = '';
        $Input['amount'] = '';
        $Input['subscription_status'] = '';
        $Input['current_period_start'] = '';
        $Input['current_period_end'] = '';
        $Input['start_date'] = '';
        $Input['card_number'] = '';
        $Input['card_exp_month'] = '';
        $Input['exp_year'] = '';
        $Input['name_on_card'] = ucfirst(trim($request->firstname)).' '.ucfirst(trim($request->lastname));
        $Input['reg_step_1'] = '';
        $Input['reg_step_2'] = '';
        $Input['reg_step_3'] = '';
        $Input['reg_step_4'] = ''; 
        $Input['isprofilecomplete'] = ''; 
        $Input['status'] = '1';
        $Input['isdeleted'] = '0';
        $Input['isapproved'] = '1';
        $Input['isactivationcomplete'] = '0';
        $Input['logins'] = '0';
        $Input['created_by'] = '';
        $Input['updated_by'] = '';

        $auth_user = User::create($Input);
        if($auth_user) {
            $token = JWTAuth::fromUser($auth_user);
            //$user = new UserResource($auth_user); 
            $user = User::where('id', $auth_user->id)->first()->toArray();
            $from_email = env('MAIL_FROM_ADDRESS');
            $firstname = $user['firstname'];
            $lastname = $user['lastname'];
            $email = $request->email;
            $user_device = $user['device'];
            if($user_device=='mobile'){
                $old_active_code = $user['active_code'];
                $active_code = substr($old_active_code, -6);
            } else {
                $active_code = $user['active_code'];
            }
            $sendemail = Mail::to($email)->send(new SendActivationCode($firstname,$lastname,$email,$active_code,$user_device));
            
            $credentials = $request->only('email', 'password');
            if ($token = $this->guard()->attempt($credentials)) {
                $auth_user = $this->guard()->user(); 
                $logindata = [
                    'user_id' => $auth_user->id,
                    'login_time' => Carbon::now(),
                    'browser' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
                    'operating_system' => isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : null,
                    'ip_address'  => isset($_SERVER['REMOTE_ADDR']) ? ip2long($_SERVER['REMOTE_ADDR']) : null,
                    'status'     => '1',
                    'deleted' => '0',
                ];
                //$lhId = Loginhistory::create($logindata);
                User::where('id', $auth_user->id)->update(['logins' => $auth_user->logins + 1, 'last_login' => Carbon::now(), 'isonline' => '1']);
            
                return response()->json(['status'=>true,'message'=>'User login successfully','error'=>'','token'=>$token,'data'=>$user]);   
            } else {
                return response()->json(['status'=>false,'message'=>'User Doesn`t Exist With This Email','error'=>'Invalid credentials']);
            }
            return response()->json(['status'=>true,'message'=>'User created successfully A Email Verfication link Is Sent To Your Email Account Please Verify Your Account','error'=>'','token'=>$token,'data'=>$user,'mailsend'=>$sendemail]);
            
        } else {
            return response()->json(['status'=>false,'message'=>'Sorry fail to create user. Please try again.','error'=>'','data'=>'']); 
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

public function login(Request $request)
{   
   /* try{*/
        $login_type = filter_var($request->email, FILTER_VALIDATE_EMAIL ) 
        ? 'email' 
        : 'username';
        $request->merge([ $login_type => $request->email ]);
        $credentials = $request->only($login_type, 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            $auth_user = $this->guard()->user(); 
            /*$logindata = [
                'user_id' => $auth_user->id,
                'login_time' => Carbon::now(),
                'browser' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
                'operating_system' => isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : null,
                'ip_address'  => isset($_SERVER['REMOTE_ADDR']) ? ip2long($_SERVER['REMOTE_ADDR']) : null,
                'status'     => '1',
                'deleted' => '0',
            ];*/
            $admin_url = url('/admin');
            //$lhId = Loginhistory::create($logindata);
            User::where('id', $auth_user->id)->update(['logins' => $auth_user->logins + 1, 'last_login' => Carbon::now(), 'isonline' => '1']);
            $user = User::where('id', $auth_user->id)->where('isdeleted',$auth_user->isdeleted)->first()->toArray();
            if($user['isdeleted'] == 1){
                return response()->json(['status'=>false,'message'=>'User Doesn`t Exist With This Email','error'=>'Invalid credentials']);
            } else if ($user['status'] == 0) {
                return response()->json(['status'=>false,'message'=>'Please Activate Your Account First.','error'=>'']);
            } else if ($user['role'] == 1) {
                return response()->json(['status'=>true,'messageadmin'=>'','error'=>'', 'token'=>$token,'data'=>$user]);
            } else {
                return response()->json(['status'=>true,'message'=>'User login successfully','error'=>'','token'=>$token,'data'=>$user]);
            }
          /*if($user['status'] == 0){
            return response()->json(['status'=>false,'message'=>'Please Activate Your Account First Form Your Email','error'=>'']);
           } else {
            return response()->json(['status'=>true,'message'=>'User login successfully','error'=>'','token'=>$token,'data'=>$user]);
          }*/
        }
        return response()->json(['status'=>false,'message'=>'Please Enter Valid Password or Username','error'=>'Invalid credentials','data'=>'']);

    /*} catch(\Illuminate\Database\QueryException $e) {
        $errorClass = new ErrorsClass();
        $errors = $errorClass->saveErrors($e);
        return response()->json(['status'=>false,'message'=>'','error'=>'Sql query error','data'=>''], 401); 
    } catch(\Exception $e) {
        $errorClass = new ErrorsClass();
        $errors = $errorClass->saveErrors($e);
        return response()->json(['status'=>false,'message'=>'','error'=>'Undefined variable error','data'=>''], 401);
    }*/
}

public function logout()
{   
    $auth_user = $this->guard()->user();
    User::where('id', $auth_user->id)->update(['isonline' => '0']);
    //Loginhistory::where('id', $auth_user->llhid)->update(['logout_time' => Carbon::now()]);
    $this->guard()->logout();
    return response()->json(['status'=>true,'message'=>'Successfully logged out','error'=>'','data'=>''], 200);
}

public function store(Request $request)
{
    if ($request->hasFile('profile_image')) {

        foreach($request->file('profile_image') as $file){

                        //get filename with extension
            $filenamewithextension = $file->getClientOriginalName();

                        //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                        //get file extension
            $extension = $file->getClientOriginalExtension();

                        //filename to store
            $filenametostore = $filename.'_'.uniqid().'.'.$extension;

            Storage::put('public/profile_images/'. $filenametostore, fopen($file, 'r+'));
            Storage::put('public/profile_images/thumbnail/'. $filenametostore, fopen($file, 'r+'));

                        //Resize image here
            $thumbnailpath = public_path('storage/profile_images/thumbnail/'.$filenametostore);
            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);

            $smallthumbnailpath = public_path('storage/profile_images/thumbnail/small/'.$filenametostore);
            Image::make($thumbnailpath)->resize(200, 200)->save($smallthumbnailpath);
        }
                    //return redirect('images')->with('status', "Image uploaded successfully.");
    }
}

public function forgetpassword(Request $request)
{  
   try{
      $user_email = $request->email;
      $user_data = User::WHERE('email', $user_email)->WHERE('status', '1')->WHERE('isdeleted','0')->first();
      if(!empty($user_data)){
        $firstname = $user_data->firstname;
        $lastname= $user_data->lastname;
        $email=$user_email;
        $sendemail = Mail::to($email)->send(new ForgetPassword($firstname,$lastname,$email));
        return response()->json(['status'=>true,'message'=>'Your password reset link sent to your email!','data'=>$sendemail]); 
    } else {
        return response()->json(['status'=>false,'message'=>'User does not exist!']);
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

public function Resetpassword(Request $request)
{  
    try{
        $user_email = $request->email;
        $new_password = $request->password;
        $user_dcrypt_password = trim(Hash::make($new_password));
        $update_data = User::where('email', $user_email)->where('isdeleted','0')->update(['password' => $user_dcrypt_password]);
        if($update_data){
            $user_data = User::WHERE('email', $user_email)->first();
            $user_first_name = $user_data->firstname;
            $sendemail = Mail::to($user_email)->send(new Sendresetpassword($user_email, $user_first_name));
            return response()->json(['status'=>true,'message'=>'Your New password sent your email!']); 
        } else {
            return response()->json(['status'=>false,'message'=>'Record Not found!']);
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
public function userActivation(Request $request,$active_code){
    try{
        $user = User::where('active_code',$active_code)->where('isdeleted','0')->first();
        if(!empty($user)){
            $Input =  [];
            $Input['isactivationcomplete'] = '1';
            if($user->role=='5'){
                $Input['isprofilecomplete'] = '1';
            } else {
                $Input['isprofilecomplete'] = null;
            }
            $Input['updated_at'] = date('Y-m-d h:i:s');
            $update = $user->update($Input);
            if($update){
                $user = User::where('id', $user->id)->first()->toArray();
                return response()->json(['status'=>true,'message'=>'Your account has been successfully activated ','data'=>$user], 200);  
            } else {
                return response()->json(['status'=>false,'message'=>'Your account activation has been failed','data'=>$user], 200);
            }
        } else {
            return response()->json(['status'=>false,'message'=>'Sorry user does not exist'], 200);
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

public function userVerification(Request $request){
    try{
        $user_id = $request->user_id;
        $user_data = User::where('id', $user_id)->where('status','1')->where('isdeleted','0')->first();
        $active_code = $user_data->active_code;
        $new_active_code = substr($active_code, -6);
        $user_verification_code = $request->active_code;
        //$user = User::where('active_code',$active_code)->where('isdeleted','0')->first();
        if($user_verification_code==$new_active_code){
            $Input =  [];
            $Input['isactivationcomplete'] = '1';
            $Input['updated_at'] = date('Y-m-d h:i:s');
            $update = User::where('id', $user_id)->update($Input);
            if($update){
                //$user = User::where('id', $user->id)->first()->toArray();
                return response()->json(['status'=>true,'message'=>'Your account verification code successfully.','data'=>''], 200);  
            } else {
                return response()->json(['status'=>false,'message'=>'Your account verification not match','data'=>''], 200);
            }
        } else {
            return response()->json(['status'=>false,'message'=>'Your account verification not match','data'=>''], 200);
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
public function passwordReset($email){
    $user = User::where('email',$email)->where('isdeleted','0')->where('status','1')->first();
    if(!empty($user)){
        echo "User Details found";
    }
    else{
        echo "User Details Not found";
    }
}
public function refresh()
{
    return $this->respondWithToken($this->guard()->refresh());
}
public function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
protected function respondWithToken($token)
{
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => $this->guard()->factory()->getTTL() * 999
    ]);
}
public function ResendEmail(Request $request){
    try{
        $firstname        = $request->firstname;
        $lastname         = $request->lastname;
        $email            = $request->email;
        $user_active_code = $request->active_code;
        $user_device      = $request->user_device;

        if($user_device=='mobile'){
            $old_active_code = $user_active_code;
            $active_code = substr($old_active_code, -6);
        } else {
            $active_code = $user_active_code;
        }
        $sendemail = Mail::to($email)->send(new SendActivationCode($firstname,$lastname,$email,$active_code,$user_device));
        if($sendemail){
            return response()->json(['status'=>true,'message'=>'Resend email sent successfully.','data'=>''], 200);
        } else {
            return response()->json(['status'=>false,'message'=>'Resend email not sent successfully.','data'=>''], 200);
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
public function linkedin(Request $request){
    $todayTime = date('ga', strtotime(Carbon::now()));
    $todayWeekName = Carbon::now()->format('l');
    //$todayTime = '8am';
    $column_name = strtolower($todayWeekName).'_timing';
    $schedule_timimg = Schedule::whereRaw('FIND_IN_SET(?,'.$column_name.')', [$todayTime])->get()->toArray();
    if($schedule_timimg){
        foreach ($schedule_timimg as $scheduletimimg) {
            $user_id = $scheduletimimg['user_id'];
            $business_locations_data = Businesslocations::where('user_id', $user_id)->inRandomOrder()->limit(1)->get();
            $user_satisfaction = $business_locations_data[0]['client_satisfaction'];
            $business_place_id = $business_locations_data[0]['business_place_id'];
            $linkedin_code = $business_locations_data[0]['linkedin_code'];
            $linkedin_access_token = $business_locations_data[0]['linkedin_access_token'];
            if($user_satisfaction=='1'){
                $user_satisfaction_rating = '4';
                $live_review_data = Livereviews::where('business_user_id', $user_id)->where('live_review_rating', '>=', $user_satisfaction_rating)->inRandomOrder()->limit(1)->get();
                $business_review_data = Businessreview::where('business_user_id', $user_id)->where('reviewer_rating', '=', $user_satisfaction_rating)->inRandomOrder()->limit(1)->get();
                $reviews = array_merge($business_review_data->toArray(), $live_review_data->toArray());
            } elseif($user_satisfaction=='0'){
                $user_satisfaction_rating = '5';
                $live_review_data = Livereviews::where('business_user_id', $user_id)->where('live_review_rating', '=', $user_satisfaction_rating)->inRandomOrder()->limit(1)->get();
                $business_review_data = Businessreview::where('business_user_id', $user_id)->where('reviewer_rating', '=', $user_satisfaction_rating)->inRandomOrder()->limit(1)->get();
                $reviews = array_merge($business_review_data->toArray(), $live_review_data->toArray());
            } else {
                $user_satisfaction_rating = '';
                $reviews = array();
            }
            if($linkedin_code && $linkedin_access_token){
                $link = 'YOUR_LINK_TO_SHARE';
                //$access_token = 'YOUR_ACCESS_TOKEN';
                $linkedin_id = '92b152211';
                $body = new \stdClass();
                $body->content = new \stdClass();
                $body->content->contentEntities[0] = new \stdClass();
                $body->text = new \stdClass();
                //$body->content->contentEntities[0]->thumbnails[0] = new \stdClass();
                //$body->content->contentEntities[0]->entityLocation = $link;
                //$body->content->contentEntities[0]->thumbnails[0]->resolvedUrl = "THUMBNAIL_URL_TO_POST";
                $body->content->title = $reviews[0]['live_review_reviewer'];
                $body->owner = 'urn:li:organization:92b152211';///.$linkedin_id;
                $body->text->text = $reviews[0]['live_review_text'];
                $body_json = json_encode($body, true);
                /*echo '<pre>';
                print_r($body_json);
                echo '</pre>';
                exit();*/
                try {
                    $client = new Client(['base_uri' => 'https://api.linkedin.com']);
                    $response = $client->request('POST', '/v2/shares', [
                        'headers' => [
                            "Authorization" => "Bearer " . $linkedin_access_token,
                            "Content-Type"  => "application/json",
                            "x-li-format"   => "json"
                        ],
                        'body' => $body_json,
                    ]);
                  
                    if ($response->getStatusCode() !== 201) {
                        echo 'Error: '. $response->getLastBody()->errors[0]->message;
                    }

                    echo '<pre>';
                        print_r($response);
                    echo '</pre>';

                    echo 'Post is shared on LinkedIn successfully.';
                } catch(Exception $e) {
                    echo $e->getMessage(). ' for link '. $link;
                }
            }
        }
    } else {
        echo 'notfound';
    }
}
public function guard()
{
    return Auth::guard();
}
}
