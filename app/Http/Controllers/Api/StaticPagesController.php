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
use App\Models\StaticPages;

class StaticPagesController extends Controller
{


	public function GetAllStaticPages(Request $request)
    {
    	try{
    		$staticpages = StaticPages::where('static_pages.status', '1')->where('static_pages.is_deleted', '0')->orderBy('static_pages.id', 'ASC')->paginate(10);

    		
    		if($staticpages){
    			return response()->json(['status'=>true,'message'=>'Static pages Listings','error'=>'','data'=>$staticpages], 200);
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
	
	public function GetStaticPages(Request $request)
    {
    	try{
    		$staticpages = StaticPages::where('status', '1')->where('is_deleted', '0')->get();
    		if($staticpages){
    			return response()->json(['status'=>true,'message'=>'Static pages Listings','error'=>'','data'=>$staticpages], 200);
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
	
	public function deleteStaticPages(Request $request)
    {
    	try{
    		$staticpage_id = $request->staticpage_id;
    		$delete_static_pages = StaticPages::where('id', $staticpage_id)->update(['status' => '0', 'is_deleted' => '1']);
    		if($delete_static_pages){
    			return response()->json(['status'=>true,'message'=>'Static page deleted successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Static page not deleted successfully!','error'=>'','data'=>''], 200);
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
	
	public function CreateStaticPage(Request $request)
    {
    	try{
    	
    		$pagetitle = ucwords(trim($request->page_title));
    		
    		 $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($request->page_title));
    	
    		$checkstatic_page = StaticPages::select('title')->where('static_pages.title',$pagetitle)->where('static_pages.status', '1')->where('static_pages.is_deleted', '0')->first();
    		
    		if($checkstatic_page){
    		    
    		    return response()->json(['status'=>'title_error','message'=>'Please choose different page title!','error'=>'','data'=>''], 200);
    		    
    		    
    		}else {
    		    
    		    $page = new StaticPages();
    		    $page->title = $pagetitle;
    		    $page->slug = $slug;
    		    $page->description = $request->page_desc;
    		    
    		    if($request->file('banner_img')){
                	$file = $request->file('banner_img');
                	$filename = date('YmdHi').$file->getClientOriginalName();
                	$file-> move(public_path('StaticPages'), $filename);
                	$page->image = $filename;
            	}
    		
        		$save_data = $page->save();
        		if($save_data){
        			return response()->json(['status'=>'ok','message'=>'Static page created successfully!','error'=>'','data'=>''], 200);
        		} else {
        			return response()->json(['status'=>'notok','message'=>'Static page not created successfully!','error'=>'','data'=>''], 200);
        		}
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
    
     public function UpdateStaticPage(Request $request, $id)
    {
    	try{
    	    
    	 
            	$pagetitle = ucwords(trim( $request->input('edit_page_title')));
            	
            	 $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($request->edit_page_title));
            	
            
        		$checkstatic_page = StaticPages::select('title')->where('static_pages.id','!=',$id)->where('static_pages.title',$pagetitle)->where('static_pages.status', '1')->where('static_pages.is_deleted', '0')->first();
        		
        
        		if($checkstatic_page ){
        		    
        		    return response()->json(['status'=>'title_error','message'=>'Please choose different page title!','error'=>'','data'=>''], 200);
        		    
        		    
        		}else {
    	    
    	            $page = StaticPages::find($id);
    	    
    	        	$page['title'] = $pagetitle;
    	        	$page['slug'] = $slug;
    	        	$page['description'] = $request->input('edit_page_desc');
    			
                		if($request->file('edit_banner_image')){
                        	$file = $request->file('edit_banner_image');
                        	$filename = date('YmdHi').$file->getClientOriginalName();
                        	$file-> move(public_path('StaticPages'), $filename);
                        	$page['image'] = $filename;
                    	}
        		    $update_data = $page->update();
            		if($update_data){
            			return response()->json(['status'=>'ok','message'=>'Static page updated successfully!','error'=>'','data'=>''], 200);
            		} else {
            			return response()->json(['status'=>'notok','message'=>'Static page not updated successfully!','error'=>'','data'=>''], 200);
            		}
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
    
    public function GetSingleStaticPage(Request $request, $id)
    {
    	try{
    		$single_static_page = StaticPages::where('slug', $id)->first();
    
    		
    		if($single_static_page){
    			return response()->json(['status'=>true,'message'=>'Static Page Listings','error'=>'','data'=>$single_static_page], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Static page','error'=>'','data'=>''], 200);
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
	
	public function GetSingleStaticPageSlugData(Request $request, $slug)
    {
    	try{
    		$single_static_page = StaticPages::where('slug', $slug)->first();
    		if($single_static_page){
    			return response()->json(['status'=>true,'message'=>'Static Page Listings','error'=>'','data'=>$single_static_page], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Static page','error'=>'','data'=>''], 200);
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
	
	public function AdminSearchStaticpage(Request $request)
    {
    	try{
    		if(trim($request->keywords)){
	    		$query = DB::table('static_pages');
	    		$query->select('static_pages.*');
	    		if(trim($request->keywords)) {
	               $query->where('static_pages.title', 'like', '%'.trim($request->keywords).'%');
	            }
	            $packges_data = $query->paginate(10);
	        } else {
	        	$packges_data = StaticPages::where('static_pages.status', '1')->where('static_pages.is_deleted', '0')->orderBy('static_pages.id', 'DESC')->paginate(10);
	        }
    		if($packges_data){
    			return response()->json(['status'=>true,'message'=>'Search Static page Listings','error'=>'','data'=>$packges_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Static page','error'=>'','data'=>''], 200);
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