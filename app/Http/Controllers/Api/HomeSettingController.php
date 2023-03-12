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
use Log;
use DB;
use App\Classes\ErrorsClass;

class HomeSettingController extends Controller
{
	public function GetAllHeaderAnnoucement(Request $request)
    {
    	try{
    		$header_annoucement_data = HomeSetting::where('status', '1')->where('is_deleted', '0')->paginate(10);
    		if($header_annoucement_data){
    			return response()->json(['status'=>true,'message'=>'Header Annoucement Listings','error'=>'','data'=>$header_annoucement_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Header Annoucement','error'=>'','data'=>''], 200);
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
	public function GetSingleHeaderAnnoucement(Request $request, $id)
    {
    	try{
    		$header_annoucement_data = HomeSetting::where('id', $id)->where('status', '1')->where('is_deleted', '0')->first();
    		if($header_annoucement_data){
    			return response()->json(['status'=>true,'message'=>'Header Annoucement Listings','error'=>'','data'=>$header_annoucement_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Header Annoucement','error'=>'','data'=>''], 200);
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
	public function CreateHeaderAnnoucement(Request $request)
    {
    	try{
    		$home_setting = new HomeSetting();
    		$home_setting->banner_image = null;
    		$home_setting->banner_text = null;
    		$home_setting->coe_id = null;
    		$home_setting->department_id = null;
    		$home_setting->header_annoucement_text = $request->header_annoucement_text;
    		$home_setting->header_annoucement_link = $request->header_annoucement_link;
    		$home_setting->header_phone_no = $request->header_phone_no;
    		$save_data = $home_setting->save();
    		if($save_data){
    			return response()->json(['status'=>true,'message'=>'Header Annoucement created successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Header Annoucement not created successfully!','error'=>'','data'=>''], 200);
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
    public function UpdateHeaderAnnoucement(Request $request, $id)
    {
    	try{
    		$home_setting = HomeSetting::find($id);
    		$home_setting['banner_image'] = null;
    		$home_setting['banner_text'] = null;
    		$home_setting['coe_id'] = null;
    		$home_setting['department_id'] = null;
    		$home_setting['header_annoucement_text'] = $request->input('edit_header_annoucement_text');
    		$home_setting['header_annoucement_link'] = $request->input('edit_header_annoucement_link');
    		$home_setting['header_phone_no'] = $request->input('edit_header_phone_no');
    		$update_data = $home_setting->update();
    		if($update_data){
    			return response()->json(['status'=>true,'message'=>'Header Annoucement updated successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Header Annoucement not updated successfully!','error'=>'','data'=>''], 200);
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
}