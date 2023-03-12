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
use App\Models\BannerButtonLink;
use Log;
use DB;
use App\Classes\ErrorsClass;

class BannerButtonLinkController extends Controller
{
	public function SaveBannerButtonLink(Request $request)
    {
    	try{
    		$bannerbuttonlink = new BannerButtonLink();
    		//$bannerbuttonlink->banner_btn_icon = $request->banner_button_icon;
    		$bannerbuttonlink->banner_btn_text = $request->banner_button_text;
    		$bannerbuttonlink->banner_btn_link = $request->banner_button_link;

    		if($request->file('banner_button_icon')){
            	$file = $request->file('banner_button_icon');
            	$filename = date('YmdHi').$file->getClientOriginalName();
            	$file-> move(public_path('BannerButtonImg'), $filename);
            	$bannerbuttonlink->banner_btn_icon = $filename;
        	}
    		$save_data = $bannerbuttonlink->save();
    		if($save_data){
    			return response()->json(['status'=>true,'message'=>'Banner Button Link created successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Banner Button Link not created successfully!','error'=>'','data'=>''], 200);
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
    public function GetAllBannerButtonLink(Request $request)
    {
    	try{
    		//$banner_btn_data = BannerButtonLink::select('static_pages.slug', 'banner_button_link.*')->join('static_pages', 'banner_button_link.banner_btn_link', 'static_pages.id')->where('banner_button_link.status', '1')->where('banner_button_link.is_deleted', '0')->get();
    		$banner_btn_data = BannerButtonLink::select('department.department_name', 'department.id as department_id','banner_button_link.*')->join('department', 'banner_button_link.banner_btn_link', 'department.id')->where('banner_button_link.status', '1')->where('banner_button_link.is_deleted', '0')->get();
    		if($banner_btn_data){
    			return response()->json(['status'=>true,'message'=>'Banner Button Link Listings','error'=>'','data'=>$banner_btn_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Banner Button Link','error'=>'','data'=>''], 200);
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
	public function GetSingleBannerButtonLinkData(Request $request, $id)
    {
    	try{
    		$single_banner_btn_data = BannerButtonLink::where('id', $id)->first();
    		if($single_banner_btn_data){
    			return response()->json(['status'=>true,'message'=>'Banner Button Link Listings','error'=>'','data'=>$single_banner_btn_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Banner Button Link','error'=>'','data'=>''], 200);
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
	public function UpdateBannerButtonLink(Request $request, $id)
    {
    	try{
    		$bannerbuttonlink = BannerButtonLink::find($id);
    		//$bannerbuttonlink['banner_btn_icon'] = $request->input('edit_banner_button_icon');
    		$bannerbuttonlink['banner_btn_text'] = $request->input('edit_banner_button_text');
    		$bannerbuttonlink['banner_btn_link'] = $request->input('edit_banner_button_link');
    		
    		if($request->file('edit_banner_button_icon')){
            	$file = $request->file('edit_banner_button_icon');
            	$filename = date('YmdHi').$file->getClientOriginalName();
            	$file-> move(public_path('BannerButtonImg'), $filename);
            	$bannerbuttonlink['banner_btn_icon'] = $filename;
        	}
    		$update_data = $bannerbuttonlink->update();
    		if($update_data){
    			return response()->json(['status'=>true,'message'=>'Banner Button Link updated successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Banner Button Link not updated successfully!','error'=>'','data'=>''], 200);
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
    public function deleteBannerButtonLink(Request $request)
    {
    	try{
    		$banner_btn_id = $request->bannerbtnlink_id;
    		$delete_banner_btn_link_data = BannerButtonLink::where('id', $banner_btn_id)->update(['status' => '0', 'is_deleted' => '1']);
    		if($delete_banner_btn_link_data){
    			return response()->json(['status'=>true,'message'=>'Banner Button Link deleted successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Banner Button Link not deleted successfully!','error'=>'','data'=>''], 200);
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