<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Errorlogs;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; 
use JWTFactory;
use JWTAuth;
use Validator;
use Config;
use Log;
use Event;
use App\Events\UserRegistered;
use DB;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Classes\ErrorsClass;
use Image;

class ErrorLogController extends Controller
{   

    public function errorLists()
    {
        try{
            $errors = Errorlogs::where('status', '=', '1')->where('deleted', '=', '0')->orderby('id','DESC')->paginate(Config::get('constant.pagination'));
            return response()->json(['status'=>true,'message'=>'Errors detail','error'=>'','data'=>$errors], 200);
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

    public function errorSearch(Request $request) {
       try{
            $input = $request->all();
            $search_data = $input['keyword'];
            $errors = Errorlogs::where('status', '=', '1')
                    ->where('deleted', '=', '0')
                    ->where(
            function($query) use ($search_data){
                $query->where('error_message', 'LIKE', '%'.$search_data.'%');
                $query->orWhere('file_name', 'LIKE', '%'.$search_data.'%');
                $query->orWhere('operating_system', 'LIKE', '%'.$search_data.'%');
                $query->orWhere('browser', 'LIKE', '%'.$search_data.'%');
                $query->orWhere('created_at', 'LIKE', '%'.$search_data.'%');
            })
                  ->orderBy('id','DESC')
                  ->paginate(Config::get('constant.pagination'));
           
            return response()->json(['status'=>true,'message'=>'Errors detail','error'=>'','data'=>$errors], 200);
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

    public function geterrorDetails(Request $request, $id) {
      try{
        $isError = Errorlogs::find($id);
        if ($isError) {
            $error = Errorlogs::where('id', $id)->first()->toArray();
            return response()->json(['status'=>true,'message'=>'Error details','error'=>'','data'=>$error], 200);
            } else {
            return response()->json(['status'=>false,'message'=>'Error not found','error'=>'','data'=>''], 400);
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