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
use App\Models\Packages;
use App\Models\Publications;
use App\Models\Pre_Existing_Conditon;
use Log;
use DB;
use App\Classes\ErrorsClass;

class PackagesController extends Controller
{


	public function GetAllPackages(Request $request)
    {
    	try{
    		$packges_data = Packages::select('department.department_name','pre_existing_conditon.name as pre_name', 'packages.*')->join('department', 'packages.dept_id', '=', 'department.dept_id')->join('pre_existing_conditon', 'packages.pre_existing_conditon_id', '=', 'pre_existing_conditon.id')->where('packages.status', '1')->where('packages.is_deleted', '0')->orderBy('packages.id', 'DESC')->paginate(10);

    		
    		if($packges_data){
    			return response()->json(['status'=>true,'message'=>'Packages Listings','error'=>'','data'=>$packges_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Packages','error'=>'','data'=>''], 200);
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
	
	
    public function getAllPreCondtion(Request $request)
    {
    	try{
    		$pre_data = Pre_Existing_Conditon::where('status', '1')->where('is_deleted', '0')->get();
    		return response()->json(['status'=>true,'message'=>'All lists of pre_data','error'=>'','data'=>$pre_data], 200);
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
	
	public function deletePackage(Request $request)
    {
    	try{
    		$package_id = $request->package_id;
    		$delete_package_data = Packages::where('id', $package_id)->update(['status' => '0', 'is_deleted' => '1']);
    		if($delete_package_data){
    			return response()->json(['status'=>true,'message'=>'package deleted successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'package not deleted successfully!','error'=>'','data'=>''], 200);
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
	
    public function CreatePackage(Request $request)
    {
    	try{
    		$package = new Packages();
    		$package->name = $request->package_name;
    		$package->description = $request->package_desc;
    		
    		$package->amount = $request->package_fees;
    		$package->dept_id = $request->package_department;
    		$package->pre_existing_conditon_id = $request->package_pre_condition;
    		$package->age = $request->package_age;
    		$package->gender = $request->package_gender;
    		
    		
    		if($request->file('package_profile')){
            	$file = $request->file('package_profile');
            	$filename = date('YmdHi').$file->getClientOriginalName();
            	$file-> move(public_path('Packagesimg'), $filename);
            	$package->image = $filename;
        	}
    		
    		$save_data = $package->save();
    		if($save_data){
    			return response()->json(['status'=>true,'message'=>'package created successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'package not created successfully!','error'=>'','data'=>''], 200);
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
    
    public function UpdatePackage(Request $request, $id)
    {
    	try{
    		$package = Packages::find($id);
    		$package['name'] = $request->input('edit_package_name');
    		$package['description'] = $request->input('edit_package_description');
    		$package['amount'] = $request->input('edit_package_amount');
    		$package['dept_id'] = $request->input('edit_package_dept_id');
    		$package['pre_existing_conditon_id'] = $request->input('edit_package_pre_existing_conditon_id');
    		$package['age'] = $request->input('edit_package_age');
    		$package['gender'] = $request->input('edit_package_gender');
    			
    		
    		if($request->file('edit_package_profile')){
            	$file = $request->file('edit_package_profile');
            	$filename = date('YmdHi').$file->getClientOriginalName();
            	$file-> move(public_path('Packagesimg'), $filename);
            	$package['image'] = $filename;
        	}
    		$update_data = $package->update();
    		if($update_data){
    			return response()->json(['status'=>true,'message'=>'Packages updated successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Packages not updated successfully!','error'=>'','data'=>''], 200);
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
    
    public function GetSinglePackageData(Request $request, $name)
    {
    	try{
    		$single_package_data = Packages::where('name', 'like', '%' .trim($name). '%')->first();
    		if($single_package_data){
    			return response()->json(['status'=>true,'message'=>'Packages Listings','error'=>'','data'=>$single_package_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Packages','error'=>'','data'=>''], 200);
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
	
	public function GetSinglePackageDetails(Request $request, $id)
    {
    	try{
    	    
    	   
    	   $packges_data = Packages::select('department.department_name','pre_existing_conditon.name as pre_name', 'packages.*')->join('department', 'packages.dept_id', '=', 'department.dept_id')->join('pre_existing_conditon', 'packages.pre_existing_conditon_id', '=', 'pre_existing_conditon.id')->where('packages.status', '1')->where('packages.is_deleted', '0')->where('packages.id', $id)->first();
    	   
    		if($packges_data){
    			return response()->json(['status'=>true,'message'=>'Package Listings','error'=>'','data'=>$packges_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Package','error'=>'','data'=>''], 200);
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
	
	public function AdminSearchPackage(Request $request)
    {
    	try{
    		if(trim($request->keywords)){
	    		$query = DB::table('packages');
	    		$query->select('department.department_name', 'packages.*');
	    		$query->join('department', 'packages.dept_id', '=', 'department.dept_id');
	    		if(trim($request->keywords)) {
	               $query->where('packages.name', 'like', '%'.trim($request->keywords).'%');
	               $query->orwhere('department.department_name', 'like', '%'.trim($request->keywords).'%');
	            }
	            $packges_data = $query->paginate(10);
	        } else {
	        	$packges_data = Packages::select('department.department_name','pre_existing_conditon.name as pre_name', 'packages.*')->join('department', 'packages.dept_id', '=', 'department.dept_id')->join('pre_existing_conditon', 'packages.pre_existing_conditon_id', '=', 'pre_existing_conditon.id')->where('packages.status', '1')->where('packages.is_deleted', '0')->orderBy('packages.id', 'DESC')->paginate(10);
	        }
    		if($packges_data){
    			return response()->json(['status'=>true,'message'=>'Search Doctors Listings','error'=>'','data'=>$packges_data], 200);
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
	public function getSearchPackageData(Request $request)
    {
    	try{
    		$query = DB::table('packages');
	    	$query->select('department.department_name', 'pre_existing_conditon.name as pre_name', 'packages.*');
	    	$query->join('department', 'packages.dept_id', '=', 'department.dept_id');
	    	$query->join('pre_existing_conditon', 'packages.pre_existing_conditon_id', '=', 'pre_existing_conditon.id');
    		if($request->input('gender')) {
	            $query->where('packages.gender', $request->input('gender'));
	        } 
	        if ($request->input('age')) {
	        	$query->where('packages.age', $request->input('age'));
	        } 
	        if ($request->input('department')) {
	        	$query->where('packages.dept_id', $request->input('department'));
	        } 
	        if ($request->input('pre_exist_condition')) {
	        	$query->where('packages.pre_existing_conditon_id', $request->input('pre_exist_condition'));
	        }
	        $query->where('packages.status', '1');
	        $query->where('packages.is_deleted', '0');
	        $query->orderBy('packages.id', 'DESC');
	        $packges_data = $query->paginate(10);
    		if($packges_data){
    			return response()->json(['status'=>true,'message'=>'Search Packages Listings','error'=>'','data'=>$packges_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Packages','error'=>'','data'=>''], 200);
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