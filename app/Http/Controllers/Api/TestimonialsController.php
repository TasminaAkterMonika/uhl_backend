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
use Log;
use App\Classes\ErrorsClass;

class TestimonialsController extends Controller
{
	public function SaveTestimonials(Request $request)
    {
    	try{
    		$Testimonials = new Testimonials();
    		$Testimonials['departmant_id'] = $request->departmant_id;
    		$Testimonials['testimonial_name'] = $request->testimonial_name;
    		$Testimonials['testimonial_desc'] = $request->testimonial_desc;
    		$Testimonials['author_id'] = $request->author_id;
    		$Testimonials['rating'] = $request->rating;
    		if($request->file('author_profile_pic')){
            	$file= $request->file('author_profile_pic');
            	$filename= date('YmdHi').$file->getClientOriginalName();
            	$file-> move(public_path('AuthorProfileImg'), $filename);
            	$Testimonials['author_profile_pic']= $filename;
        	}
        	$save_data = $Testimonials->save();
    		if($save_data){
    			return response()->json(['status'=>true,'message'=>'Testimonials saved successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Testimonials not saved successfully','error'=>'','data'=>''], 200);
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
	public function GetAllTestimonials(Request $request)
    {
    	try{
    		$testimonials_data = Testimonials::select('doctors.doctor_name as author_name', 'testimonials.*')->join('doctors', 'testimonials.author_id', '=', 'doctors.id')->where('testimonials.status', '1')->where('testimonials.is_deleted', '0')->orderBy('testimonials.id', 'DESC')->paginate(10);
    		if($testimonials_data){
    			return response()->json(['status'=>true,'message'=>'Testimonials Listings','error'=>'','data'=>$testimonials_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of testimonials','error'=>'','data'=>''], 200);
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
	public function GetDoctorTestimonials(Request $request)
    {
    	try{
    		$doctor_testimonials_data = Testimonials::select('doctors.doctor_name as author_name', 'doctors.doctor_profile as author_image','testimonials.*')->join('doctors', 'testimonials.author_id', '=', 'doctors.id')->where('testimonials.author_id', $request->doctor_id)->where('testimonials.status', '1')->where('testimonials.is_deleted', '0')->orderBy('testimonials.id', 'DESC')->get();
    		if($doctor_testimonials_data){
    			return response()->json(['status'=>true,'message'=>'Doctor Testimonials Listings','error'=>'','data'=>$doctor_testimonials_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of doctor testimonials','error'=>'','data'=>''], 200);
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
	public function AdminSearchTestimonials(Request $request)
    {
    	try{
    		if(trim($request->keywords)){
	    		$query = DB::table('testimonials');
	    		if(trim($request->keywords)) {
	               $query->where('testimonial_name', 'like', '%'.trim($request->keywords).'%');
	               $query->orwhere('author_name', 'like', '%'.trim($request->keywords).'%');
	            }
	            $query->where('status', '1');
	            $query->where('is_deleted', '0');
	            $testimonials_data = $query->paginate(10);
	        } else {
	        	$testimonials_data = Testimonials::where('status', '1')->where('is_deleted', '0')->orderBy('id', 'DESC')->paginate(10);
	        }
    		if($testimonials_data){
    			return response()->json(['status'=>true,'message'=>'Search Testimonials Listings','error'=>'','data'=>$testimonials_data], 200);
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
	public function GetSingleTestimonials(Request $request, $id)
    {
    	try{
    		$single_testimonials_data = Testimonials::where('id', $id)->where('status', '1')->where('is_deleted', '0')->first();
    		if($single_testimonials_data){
    			return response()->json(['status'=>true,'message'=>'Testimonials Listings','error'=>'','data'=>$single_testimonials_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of testimonials','error'=>'','data'=>''], 200);
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
	public function UpdateTestimonials(Request $request, $id)
    {
    	try{
    		$Testimonials = Testimonials::find($id);
	        $Testimonials['departmant_id'] = $request->input('edit_departmant_id');
	        $Testimonials['testimonial_name'] = $request->input('edit_testimonial_name');
	        $Testimonials['testimonial_desc'] = $request->input('edit_testimonial_desc');
	        $Testimonials['author_id'] = $request->input('edit_author_id');
	        $Testimonials['rating'] = $request->input('edit_rating');
	        if($request->file('edit_author_profile_pic')){
            	$file= $request->file('edit_author_profile_pic');
            	$filename= date('YmdHi').$file->getClientOriginalName();
            	$file-> move(public_path('AuthorProfileImg'), $filename);
            	$Testimonials['author_profile_pic']= $filename;
        	}
	        $update_data = $Testimonials->update();
    		if($update_data){
    			return response()->json(['status'=>true,'message'=>'Testimonials updated successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Testimonials not updated successfully','error'=>'','data'=>''], 200);
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
	
	
	public function deleteTestimonials(Request $request)
    {
    	try{
    	    $id = $request->testimonial_id;
    		$delete_testimonials_data = Testimonials::where('id', $id)->update(['status' => '0', 'is_deleted' => '1']);
    		if($delete_testimonials_data){
    			return response()->json(['status'=>true,'message'=>'Testimonials deleted successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Testimonials not deleted successfully!','error'=>'','data'=>''], 200);
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