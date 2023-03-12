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
use App\Models\NewsEvents;
use App\Models\Publications;
use App\Models\Doctors;
use Log;
use DB;
use App\Classes\ErrorsClass;

class PublicationsController extends Controller
{
	public function SavePublications(Request $request)
    {
    	try{
    		$Publications = new Publications();
    		$Publications['publications_title'] = $request->input('publications_title');
    		$Publications['publications_desc'] = $request->input('publications_desc');
    		$Publications['doctor_id'] = $request->doctor_id;
    		if($request->file('publications_pic')){
            	$file= $request->file('publications_pic');
            	$filename= date('YmdHi').$file->getClientOriginalName();
            	$file-> move(public_path('PublicationsImg'), $filename);
            	$Publications['publications_pic']= $filename;
        	}
        	$save_data = $Publications->save();
    		if($save_data){
    			return response()->json(['status'=>true,'message'=>'Publications saved successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Publications not saved successfully','error'=>'','data'=>''], 200);
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
	
	public function GetDoctors(Request $request)
    {
    	try{
    		$department_data = Doctors::select('id','doctor_name')->where('status', '1')->where('is_deleted', '0')->orderBy('id', 'DESC')->get();
    		return response()->json(['status'=>true,'message'=>'All lists of department','error'=>'','data'=>$department_data], 200);
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
	
	public function GetAllPublications(Request $request)
    {
    	try{
    // 		$publications_data = Publications::where('status', '1')->where('is_deleted', '0')->orderBy('id', 'DESC')->get();
    		
    		$publications_data = Publications::select('publications_pic','publications_title','publications_desc','publications.id','doctor_name')->join('doctors', 'publications.doctor_id', '=', 'doctors.id')->where('publications.status', '1')->where('publications.is_deleted', '0')->orderBy('publications.id', 'DESC')->paginate(10);
    		
    		if($publications_data){
    			return response()->json(['status'=>true,'message'=>'Publications Listings','error'=>'','data'=>$publications_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Publications','error'=>'','data'=>''], 200);
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
	public function AdminSearchPublications(Request $request)
    {
    	try{
    		if(trim($request->keywords)){
	    		$query = DB::table('publications');
	    		$query->select('publications_pic','publications_title','publications_desc', 'publications.id','doctor_name');
	    		$query->join('doctors', 'publications.doctor_id', '=', 'doctors.id');
	    		if(trim($request->keywords)) {
	               $query->where('publications.publications_title', 'like', '%'.trim($request->keywords).'%');
	               $query->orwhere('doctors.doctor_name', 'like', '%'.trim($request->keywords).'%');
	            }
	            $query->where('publications.status', '1');
	            $query->where('publications.is_deleted', '0');
	            $query->orderBy('publications.id', 'DESC');
	            $publications_data = $query->paginate(10);
	        } else {
	        	$publications_data = Publications::select('publications_pic','publications_title','publications_desc', 'publications.id','doctor_name')->join('doctors', 'publications.doctor_id', '=', 'doctors.id')->where('publications.status', '1')->where('publications.is_deleted', '0')->orderBy('publications.id', 'DESC')->paginate(10);
	        }
    		if($publications_data){
    			return response()->json(['status'=>true,'message'=>'Search Testimonials Listings','error'=>'','data'=>$publications_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Testimonials','error'=>'','data'=>''], 200);
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
	public function GetDoctorPublications(Request $request, $id)
    {
    	try{
    		$doctor_publications_data = Publications::where('doctor_id', $id)->where('status', '1')->where('is_deleted', '0')->orderBy('id', 'DESC')->get();
    		if($doctor_publications_data){
    			return response()->json(['status'=>true,'message'=>'Doctor Publications Listings','error'=>'','data'=>$doctor_publications_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Doctor Publications','error'=>'','data'=>''], 200);
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
	public function GetPublications(Request $request)
    {
    	try{
    		$publications_data = Publications::where('status', '1')->where('is_deleted', '0')->orderBy('id', 'DESC')->get()->toArray();
    		
    		if($publications_data){
    			return response()->json(['status'=>true,'message'=>'Publications Listings','error'=>'','data'=>$publications_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Publications','error'=>'','data'=>''], 200);
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
	
	public function GetSinglePublications(Request $request, $id)
    {
    	try{
    		$single_publications_data = Publications::where('id', $id)->where('status', '1')->where('is_deleted', '0')->first();
    		if($single_publications_data){
    			return response()->json(['status'=>true,'message'=>'Publications Listings','error'=>'','data'=>$single_publications_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Publications','error'=>'','data'=>''], 200);
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
	public function UpdatePublications(Request $request, $id)
    {
    	try{
    		$Publications = Publications::find($id);
	        $Publications['publications_title'] = $request->input('edit_publications_title');
	        $Publications['publications_desc'] = $request->input('edit_publications_desc');
	        
	          $Publications['doctor_id'] = $request->input('edit_doctor_id');
	        
	        if($request->file('edit_publications_pic')){
            	$file= $request->file('edit_publications_pic');
            	$filename= date('YmdHi').$file->getClientOriginalName();
            	$file-> move(public_path('PublicationsImg'), $filename);
            	$Publications['publications_pic']= $filename;
        	}
	        $update_data = $Publications->update();
    		if($update_data){
    			return response()->json(['status'=>true,'message'=>'Publications updated successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Publications not updated successfully','error'=>'','data'=>''], 200);
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
	public function deletePublications(Request $request)
    {
    	try{
    	    $id = $request->publications_id;
    		$delete_publications_data = Publications::where('id', $id)->update(['status' => '0', 'is_deleted' => '1']);
    		if($delete_publications_data){
    			return response()->json(['status'=>true,'message'=>'Publications deleted successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Publications not deleted successfully!','error'=>'','data'=>''], 200);
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
	
	public function GetDoctorPublicationsName(Request $request, $id)
    {
    	try{
    	    
    	   
    	    $doctors_name = Publications::select('doctors.doctor_name')->join('doctors', 'publications.doctor_id', '=', 'doctors.id')->where('publications.status', '1')->where('publications.is_deleted', '0')->where('publications.id', $id)->first();
    	   
    		if($doctors_name){
    			return response()->json(['status'=>true,'message'=>'publication doctor name','error'=>'','data'=>$doctors_name], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of doctors','error'=>'','data'=>''], 200);
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