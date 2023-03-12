<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use  App\Models\BodyPart;
use App\Models\BodyLinkDept;
use App\Models\Department;
use App\Classes\ErrorsClass;
class BodyPartsDepartController extends Controller
{
    /**
     * Get all the all data of body link database..
     */
    public function getAllBodyLink()
    {
        try{
    		$bodyDept_data = BodyLinkDept::select('department.dept_id as department_id','body_link_dept.id as body_link_dept_id','body_part.*','department.department_name')->join('department', 'body_link_dept.dept_id', '=', 'department.dept_id')->join('body_part', 'body_link_dept.bodypart_id', '=', 'body_part.id')->where(['body_link_dept.is_deleted'=>'0'])->orderBy('body_link_dept.id', 'DESC')->paginate(10);
            //dd($bodyDept_data);
			if($bodyDept_data){
    			return response()->json(['status'=>true,'message'=>'Body Parts Listings','error'=>'','data'=>$bodyDept_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Body Parts','error'=>'','data'=>''], 200);
    		}
    	} catch(\Illuminate\Database\QueryException $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Sql query error','data'=>$errors], 401); 
	    } catch(\Exception $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Undefined variable error','data'=>''], 401);
	    }
    }

    /**
     * Get all the body part from databse..
     */
    public function getBodyParts(Request $request,$gender)
    {
        try{

    		$bodyparts_data = BodyPart::where(['gender'=>$request->gender])->get();
    		return response()->json(['status'=>true,'message'=>'All lists of body parts','error'=>'','data'=>$bodyparts_data], 200);
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
     * For create a new record in databse..
     */
    public function CreateBodyParts(Request $request)
    {
    	try{
    		$bodyparts = new BodyLinkdept();
		   	$bodyparts->dept_id = $request->department_id;
		   	$bodyparts->bodypart_id=$request->body_part;
		   	$save_data = $bodyparts->save();
		   	if($save_data){
			   	return response()->json(['status'=>true,'message'=>'Body Link created successfully!','error'=>'','data'=>$save_data], 200);
		   	} else {
			   return response()->json(['status'=>false,'message'=>'Body Link not created successfully!','error'=>'','data'=>''], 200);
		   	}
			/*$department=Department::where(['department_name'=>$request->department_name])->doesntExist();
			if($department)
			{
				$Input['department_name']= $request->department_name;
				$dept = Department::insertGetId($Input);
				// return response()->json(['status'=>true,'message'=>'Department created successfully!','error'=>'','data'=>$dept], 200);
				// $body=BodyPart::where(['gender'=>$request->gender])->groupBy('gender')->doesntExist();
				// if($body)
				// {
				   $bodyparts = new BodyLinkdept();
				   $bodyparts->dept_id = $dept;
				   $bodyparts->bodypart_id=$request->body_part;
				   
				   $save_data = $bodyparts->save();
				   if($save_data){
					   return response()->json(['status'=>true,'message'=>'Body Link created successfully!','error'=>'','data'=>$save_data], 200);
				   } else {
					   return response()->json(['status'=>false,'message'=>'Body Link not created successfully!','error'=>'','data'=>''], 200);
				   }
				   	// }
			}else{
				return response()->json(['status'=>false,'message'=>'','error'=>'Department must be unique.','data'=>''], 200);
			}*/	
    	} catch(\Illuminate\Database\QueryException $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Sql query error','data'=>$errors], 401); 
	    } catch(\Exception $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Undefined variable error','data'=>''], 401);
	    }
    }
    /**
     *For create a existing record from databse..
     */
    public function deletebodylinks(Request $request)
    {
    	try{
    		$id = $request->id;
    		$delete_data = BodyLinkDept::where('id', $id)->update(['status' => '0', 'is_deleted' => '1']);
    		if($delete_data){
    			return response()->json(['status'=>true,'message'=>'Body Link Parts deleted successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Body Link Parts not deleted successfully!','error'=>'','data'=>''], 200);
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
     /**
     *Get record data according to id from databse..
     */
	public function EditBodyLink(Request $request,$id){
		try{
			$bodyDept_data = BodyLinkDept::select('department.dept_id as department_id','body_link_dept.id as body_link_dept_id','body_part.*','department.department_name')->join('department', 'body_link_dept.dept_id', '=', 'department.dept_id')->join('body_part', 'body_link_dept.bodypart_id', '=', 'body_part.id')->where('body_link_dept.id', $id)->where(['body_link_dept.is_deleted'=>'0'])->orderBy('body_link_dept.id', 'DESC')->first();
			$bodyparts_data = BodyPart::select('id','bodypart_name')->where(['gender'=>$bodyDept_data->gender])->get();
			if($bodyDept_data){
    			return response()->json(['status'=>true,'message'=>'Body link data fetched successfully!','error'=>'','data'=>$bodyDept_data,'bodypart'=>$bodyparts_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Body link data not fetched successfully!','error'=>'','data'=>''], 200);
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
    /**
     *Update record data according to id in databse..
     */
    public function UpdateBodyLink(Request $request, $id)
    {
    	try{
    		$update_data = BodyLinkDept::where('id', $id)->update(['bodypart_id'=>$request->edit_body_part_id,'dept_id'=>$request->edit_department_id]);
    		if($update_data){
    			return response()->json(['status'=>true,'message'=>'Body link data updated successfully!','error'=>'','data'=>$update_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Body link data not updated successfully!','error'=>'','data'=>''], 200);
    		}
    		/*$bodylink = BodyLinkDept::find($id);
    		
			$dept_data=Department::where('id',$bodylink->dept_id);
			$dept_data->update(['department_name'=>$request->edit_department_name]);
			$dept= $dept_data->first();

			$bodylink->update(['bodypart_id'=>$request->edit_body_part_id,'dept_id'=>$dept->id]);
    		$update_data = $bodylink->update();
    		if($update_data){
    			return response()->json(['status'=>true,'message'=>'Body link data updated successfully!','error'=>'','data'=>$update_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Body link data not updated successfully!','error'=>'','data'=>''], 200);
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
    /**
     *Show the record data according to id from databse..
     */
    public function GetSinglePageData(Request $request, $id)
    {
    	try{
    	    
			$bodyDept_data = BodyLinkDept::select('department.dept_id as department_id','body_link_dept.id as body_link_dept_id','body_part.*','department.department_name')->join('department', 'body_link_dept.dept_id', '=', 'department.dept_id')->join('body_part', 'body_link_dept.bodypart_id', '=', 'body_part.id')->where(['body_link_dept.is_deleted'=>'0'])->orderBy('body_link_dept.id', 'DESC')->first();
    		if($bodyDept_data){
    			return response()->json(['status'=>true,'message'=>'Body Link Department Listings','error'=>'','data'=>$bodyDept_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Body Link Department','error'=>'','data'=>''], 200);
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
    /**
     *Show the record data on search by department_name and bodypart_name from databse..
     */
	public function AdminSearchData(Request $request)
    {
    	try{
    		if(trim($request->keywords)){
				$bodyDept_data = BodyLinkDept::select('department.id as department_id','body_link_dept.id as body_link_dept_id','body_part.*','department.department_name')->join('department', 'body_link_dept.dept_id', '=', 'department.id')->join('body_part', 'body_link_dept.bodypart_id', '=', 'body_part.bodypart_id')->where(['body_link_dept.is_deleted'=>'0'])->orderBy('body_link_dept.id', 'DESC');
	    		if(trim($request->keywords)) {
	               $query->where('department.department_name', 'like', '%'.trim($request->keywords).'%');
	               $query->orwhere('department.department_name', 'like', '%'.trim($request->keywords).'%');
				   $query->where('body_part.bodypart_name', 'like', '%'.trim($request->keywords).'%');
	               $query->orwhere('body_part.bodypart_name', 'like', '%'.trim($request->keywords).'%');
				   $query->where('body_part.gender', 'like', '%'.trim($request->keywords).'%');
	               $query->orwhere('body_part.gender', 'like', '%'.trim($request->keywords).'%');
				$packges_data = $query;
				}
	            $packges_data = $packges_data->paginate(10);
	        } 
			else {
	        	$packges_data =BodyLinkDept::select('department.department_id', 'body_link_dept.*')
				->join('department', 'body_link_dept.dept_id', '=', 'department.department_id')
				->where('deparment.status', '1')->where('department.is_deleted', '0')->orderBy('body_link_dept.id', 'DESC')->paginate(10);
	        }
    		if($packges_data){
    			return response()->json(['status'=>true,'message'=>'Body link Listings','error'=>'','data'=>$packges_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of data','error'=>'','data'=>''], 200);
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
