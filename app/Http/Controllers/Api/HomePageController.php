<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;
use App\Models\Doctors;
use App\Models\HomeSetting;
use App\Models\BodyPart;
use App\Models\BodyLinkDept;
use App\Models\Publications;
use App\Models\Packages;
use Log;
use DB;
use App\Classes\ErrorsClass;


class HomePageController extends Controller
{
	public function SaveHomeSetting(Request $request)
    {
    	try{
    		$HomeSetting = new HomeSetting();
    		$HomeSetting['banner_text'] = $request->banner_text;
    		$HomeSetting['coe_id'] = $request->coe_id;
    		$HomeSetting['department_id'] = $request->department_id;
    		if($request->file('banner_image')){
            	$file= $request->file('banner_image');
            	$filename= date('YmdHi').$file->getClientOriginalName();
            	$file-> move(public_path('BannerImg'), $filename);
            	$HomeSetting['banner_image']= $filename;
        	}
    		$save_data = $HomeSetting->save();
    		if($save_data){
    			return response()->json(['status'=>true,'message'=>'HomeSetting saved successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'HomeSetting not saved successfully','error'=>'','data'=>''], 200);
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
    public function CreateDepartments(Request $request)
    {
    	try{
    		$department = new Department();
    		$department->department_name = $request->department_name;
    		$save_data = $department->save();
    		if($save_data){
    			return response()->json(['status'=>true,'message'=>'Department created successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Department not created','error'=>'','data'=>''], 200);
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
    public function getBodyPartDepartments(Request $request)
    {
    	try{
    		$body_part_data = BodyPart::where('bodypart_name', trim($request->bodyTitle))->where('gender', $request->bodyGender)->first();
    		$body_link_dept_data = BodyLinkDept::select('department.department_name', 'department.image', 'department.department_desc_one', 'body_link_dept.*')->join('department', 'body_link_dept.dept_id', '=', 'department.dept_id')->where('bodypart_id', $body_part_data->id)->get();
    		if($body_link_dept_data){
    			return response()->json(['status'=>true,'message'=>'Body Departments Listing!','error'=>'','data'=>$body_link_dept_data, 'bodyPartData'=>$body_part_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No Body Departments Found','error'=>'','data'=>''], 200);
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
    public function getBodyPartDepartmentsDoctors(Request $request)
    {
    	try{
    		$body_dept_doctors_data = Doctors::where('dept_id', $request->bodyDeptId)->where('status', '1')->where('is_deleted', '0')->get();
    		if($body_dept_doctors_data){
    			return response()->json(['status'=>true,'message'=>'Body Departments Listing!','error'=>'','data'=>$body_dept_doctors_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No Body Departments Found','error'=>'','data'=>''], 200);
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
    public function getDefaultSearchData(Request $request)
    {
    	try{
    		$getdefaultdoctor = Doctors::where('status', '1')->where('is_deleted', '0')->take(6)->orderBy('id', 'ASC')->get();
    		$getdefaultpackage = Packages::where('status', '1')->where('is_deleted', '0')->take(3)->orderBy('id', 'DESC')->get();
    		$getdefaultpublication = Publications::where('status', '1')->where('is_deleted', '0')->take(4)->orderBy('id', 'DESC')->get();   
    		if($getdefaultdoctor){
    			return response()->json(['status'=>true,'message'=>'Search default Listing!','error'=>'','doctor_data'=>$getdefaultdoctor, 'package_data'=>$getdefaultpackage, 'publication_data'=>$getdefaultpublication], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No Search default result Found','error'=>'','data'=>''], 200);
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
    public function getSearchData(Request $request)
    {
    	try{
    		$doctor_query = DB::table('doctors');
    		if($request->keywords) {
    			$new_string = explode(' ', $request->keywords);
    			foreach ($new_string as $key => $value) {
    				$doctor_query->where('doctor_name', 'like', '%' .$value. '%');
    			}
    		}
    		$doctor_query->where('status', '1');
    		$doctor_query->where('is_deleted', '0');
    		$doctor_query->take(6);
    		$doctor_query->orderBy('id', 'ASC');
    		$getdefaultdoctor = $doctor_query->get();


    		$package_query = DB::table('packages');
    		if(trim($request->keywords)) {
    			$package_query->where('name', 'like', '%' . trim($request->keywords) . '%');
    		}
    		$package_query->where('status', '1');
    		$package_query->where('is_deleted', '0');
    		$package_query->take(3);
    		$package_query->orderBy('id', 'DESC');
    		$getdefaultpackage = $package_query->get();

    		$publication_query = DB::table('publications');
    		if(trim($request->keywords)) {
    			$publication_query->where('publications_title', 'like', '%' . trim($request->keywords) . '%');
    		}
    		$publication_query->where('status', '1');
    		$publication_query->where('is_deleted', '0');
    		$publication_query->take(4);
    		$publication_query->orderBy('id', 'DESC');
    		$getdefaultpublication = $publication_query->get(); 
    		return response()->json(['status'=>true,'message'=>'Search Listing!','error'=>'','doctor_data'=>$getdefaultdoctor, 'package_data'=>$getdefaultpackage, 'publication_data'=>$getdefaultpublication], 200);
    		/*} else {
    			return response()->json(['status'=>false,'message'=>'No Search result Found','error'=>'','data'=>''], 200);
    		}*/
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