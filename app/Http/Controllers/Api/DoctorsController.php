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
use Log;
use DB;
use App\Classes\ErrorsClass;

class DoctorsController extends Controller
{
	public function SearchDoctors(Request $request)
    {
    	try{
    		if(trim($request->keywords)){
	    		$query = DB::table('doctors');
	    		if($request->keywords) {
    			    $new_string = explode(' ', $request->keywords);
        			foreach ($new_string as $key => $value) {
        				$query->where('doctor_name', 'like', '%' .$value. '%');
        			}
    		    }
	            $doctors = $query->get();
	        } else {
	        	$doctors = array();
	        }
    		if($doctors){
    			return response()->json(['status'=>true,'message'=>'Search Doctors Listings','error'=>'','data'=>$doctors], 200);
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
	public function AdminSearchDoctors(Request $request)
    {
    	try{
    		if(trim($request->keywords)){
	    		$query = DB::table('doctors');
	    		$query->select('department.department_name', 'doctors.*');
	    		$query->join('department', 'doctors.dept_id', '=', 'department.dept_id');
	    		if($request->keywords) {
	    		    $new_string = explode(' ', $request->keywords);
        			foreach ($new_string as $key => $value) {
        				$query->where('doctors.doctor_name', 'like', '%' .$value. '%');
        				$query->where('department.department_name', 'like', '%' .$value. '%');
        			} 
	            }
	            $doctors = $query->paginate(10);
	        } else {
	        	$doctors = Doctors::select('department.department_name', 'doctors.*')->join('department', 'doctors.dept_id', '=', 'department.dept_id')->paginate(10);
	        }
    		if($doctors){
    			return response()->json(['status'=>true,'message'=>'Search Doctors Listings','error'=>'','data'=>$doctors], 200);
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
	public function GetSingleDoctors(Request $request, $id)
    {
    	try{
    		$single_doctors_data = Doctors::where('uhl_id', trim($id))->first();
    		if($single_doctors_data){
    			return response()->json(['status'=>true,'message'=>'Doctors Listings','error'=>'','data'=>$single_doctors_data], 200);
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
	public function GetSingleDoctorProfileData(Request $request, $id)
    {
    	try{
    		$single_doctors_data = Doctors::where('id', $id)->first();
    		if($single_doctors_data){
    			return response()->json(['status'=>true,'message'=>'Doctors Listings','error'=>'','data'=>$single_doctors_data], 200);
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
	public function GetAllDoctors(Request $request)
    {
    	try{
    		$doctors_data = Doctors::select('department.department_name', 'doctors.*')->join('department', 'doctors.dept_id', '=', 'department.dept_id')->where('doctors.status', '1')->where('doctors.is_deleted', '0')->orderBy('doctors.id', 'DESC')->paginate(10);
    		if($doctors_data){
    			return response()->json(['status'=>true,'message'=>'Doctors Listings','error'=>'','data'=>$doctors_data], 200);
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
	public function GetDoctorsByDepartment(Request $request, $id)
    {
    	try{
    		$doctors_data = Doctors::select('doctors.*')->where("doctors.dept_id",trim($id))->get();
    		if($doctors_data){
    			return response()->json(['status'=>true,'message'=>'Doctors Listings','error'=>'','data'=>$doctors_data], 200);
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

	public function GetDoctors(Request $request)
    {
    	try{
    		$doctors_data = Doctors::select('department.department_name', 'doctors.*')->join('department', 'doctors.dept_id', '=', 'department.dept_id')->get();
    		if($doctors_data){
    			return response()->json(['status'=>true,'message'=>'Doctors Listings','error'=>'','data'=>$doctors_data], 200);
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
	public function CreateDoctor(Request $request)
    {
    	/*try{*/
    		$doctor = new Doctors();
    		$doctor->doctor_id = null;
    		$doctor->doctor_name = $request->doctor_name;
    		$doctor->degree = $request->doctor_degree;
    		$doctor->dept_id = $request->doctor_department;
    		$doctor->doctor_fees = $request->doctor_fees;
    		$doctor->doctor_edu = $request->doctor_edu;
    		$doctor->doctor_exp = $request->doctor_exp;
    		
    		
    		if($request->file('doctor_profile')){
            	$file = $request->file('doctor_profile');
            	$filename = date('YmdHi').$file->getClientOriginalName();
            	$file-> move(public_path('DoctorProfileImg'), $filename);
            	$doctor->doctor_profile = $filename;
        	}
    		
    		$save_data = $doctor->save();
    		if($save_data){
    			return response()->json(['status'=>true,'message'=>'Doctor created successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Doctor not created successfully!','error'=>'','data'=>''], 200);
    		}
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
    public function UpdateDoctor(Request $request, $id)
    {
    	try{
    		$doctor = Doctors::find($id);
    		$doctor['doctor_id'] = null;
    		$doctor['doctor_name'] = $request->input('edit_doctor_name');
    		$doctor['degree'] = $request->input('edit_doctor_degree');
    		$doctor['dept_id'] = $request->input('edit_doctor_department');
    		$doctor['doctor_fees'] = $request->input('edit_doctor_fees');
    		$doctor['doctor_desc'] = $request->input('edit_doctor_desc');
    		$doctor['doctor_edu'] = $request->input('edit_doctor_edu');
    		$doctor['doctor_exp'] = $request->input('edit_doctor_exp');
    			
    		
    		if($request->file('edit_doctor_profile')){
            	$file = $request->file('edit_doctor_profile');
            	$filename = date('YmdHi').$file->getClientOriginalName();
            	$file-> move(public_path('DoctorProfileImg'), $filename);
            	$doctor['doctor_profile'] = $filename;
        	}
    		$update_data = $doctor->update();
    		if($update_data){
    			return response()->json(['status'=>true,'message'=>'Doctor updated successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Doctor not updated successfully!','error'=>'','data'=>''], 200);
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
    public function deleteDoctor(Request $request)
    {
    	try{
    		$doctor_id = $request->doctor_id;
    		$delete_doctor_data = Doctors::where('id', $doctor_id)->update(['status' => '0', 'is_deleted' => '1']);
    		if($delete_doctor_data){
    			return response()->json(['status'=>true,'message'=>'Doctor deleted successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Doctor not deleted successfully!','error'=>'','data'=>''], 200);
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
	
	public function GetSingleDoctorsDetails(Request $request, $id)
    {
    	try{
    	    
    	    
    	    $doctors_data = Doctors::select('department.department_name', 'doctors.*')->join('department', 'doctors.dept_id', '=', 'department.dept_id')->where('doctors.status', '1')->where('doctors.is_deleted', '0')->where('doctors.id', $id)->first();
    	   
    		if($doctors_data){
    			return response()->json(['status'=>true,'message'=>'Doctors Listings','error'=>'','data'=>$doctors_data], 200);
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
	
		public function DoctorsPublication(Request $request, $id)
    {
    	try{
    	    
    	    
    	    $doctors_publication_data = Publications::where('publications.status', '1')->where('publications.is_deleted', '0')->where('doctor_id', $id)->get();
    	   
    		if($doctors_publication_data){
    			return response()->json(['status'=>true,'message'=>'Doctors publication data','error'=>'','data'=>$doctors_publication_data], 200);
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