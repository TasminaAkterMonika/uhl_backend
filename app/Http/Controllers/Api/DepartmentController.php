<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;
use Log;
use DB;
use Paginate;
use App\Classes\ErrorsClass;


class DepartmentController extends Controller
{
	public function getAllDepartments(Request $request)
    {
    	try{
    		$department_data = Department::where('status', '1')->where('is_deleted', '0')->paginate(10);
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
    public function AdminSearchDepartments(Request $request)
    {
    	try{
    		if(trim($request->keywords)){
	    		$query = DB::table('department');
	    		if(trim($request->keywords)) {
	               $query->where('department_name', 'like', '%'.trim($request->keywords).'%');
	            }
	            $query->where('status', '1');
	            $query->where('is_deleted', '0');
	            $department_data = $query->paginate(10);
	        } else {
	        	$department_data = Department::where('status', '1')->where('is_deleted', '0')->paginate(10);
	        }
    		if($department_data){
    			return response()->json(['status'=>true,'message'=>'Search Departments Listings','error'=>'','data'=>$department_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Departments','error'=>'','data'=>''], 200);
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
    public function getDepartments(Request $request)
    {
    	try{
    		$department_data = Department::where('status', '1')->where('is_deleted', '0')->get();
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
    public function CreateDepartments(Request $request)
    {
    	try{
    		$department = new Department();
    		$department->department_name = $request->department_name;
    		$department->dept_id = $request->department_id;
    		$department->department_desc_one = $request->department_desc_one;
    		$department->department_desc_two = $request->department_desc_two;
    		$department->department_desc_three = $request->department_desc_three;
    		$department->department_desc_four = $request->department_desc_four;
    		$department->department_desc_five = $request->department_desc_five;
    		$save_data = $department->save();
    		if($save_data){
    			return response()->json(['status'=>true,'message'=>'Department created successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Department not created successfully!','error'=>'','data'=>''], 200);
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
    public function GetSingleDepartment(Request $request, $id)
    {
    	try{
    		$single_department_data = Department::where('id', $id)->where('status', '1')->where('is_deleted', '0')->first();
    		if($single_department_data){
    			return response()->json(['status'=>true,'message'=>'Department data','error'=>'','data'=>$single_department_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Department','error'=>'','data'=>''], 200);
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
	public function UpdateDepartment(Request $request, $id)
    {
    	try{
    		$department = Department::find($id);
    		$department['department_name'] = $request->input('edit_department_name');
    		$department['department_desc_one'] = $request->input('edit_department_desc_one');
    		$department['department_desc_two'] = $request->input('edit_department_desc_two');
    		$department['department_desc_three'] = $request->input('edit_department_desc_three');
    		$department['department_desc_four'] = $request->input('edit_department_desc_four');
    		$department['department_desc_five'] = $request->input('edit_department_desc_five');
    		if($request->file('edit_department_image')){
            	$file = $request->file('edit_department_image');
            	$filename = date('YmdHi').$file->getClientOriginalName();
            	$file-> move(public_path('DepartmentImage'), $filename);
            	$department->image = $filename;
        	}
    		$update_data = $department->update();
    		if($update_data){
    			return response()->json(['status'=>true,'message'=>'Department updated successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Department not updated successfully!','error'=>'','data'=>''], 200);
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
    public function deleteDepartment(Request $request)
    {
    	try{
    		$department_id = $request->department_id;
    		$delete_department_data = Department::where('id', $department_id)->update(['status' => '0', 'is_deleted' => '1']);
    		if($delete_department_data){
    			return response()->json(['status'=>true,'message'=>'Department deleted successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Department not deleted successfully!','error'=>'','data'=>''], 200);
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
	public function checkDepartmentIdDuplicate(Request $request)
    {
    	try{
    		$department_data = Department::where('dept_id', $request->departmentId)->where('status', '1')->where('is_deleted', '0')->count();
    		if($department_data > 0){
    			return response()->json(['status'=>false,'message'=>'department id found','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>true,'message'=>'department id not found','error'=>'','data'=>''], 200);
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