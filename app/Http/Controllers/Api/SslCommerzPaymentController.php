<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Library\SslCommerz\SslCommerzNotification;
use Log;
use App\Classes\ErrorsClass;

class SslCommerzPaymentController extends Controller
{
    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function payViaAjax(Request $request)
    {
        try{
            # Here you have to receive all the order data to initate the payment.
            # Lets your oder trnsaction informations are saving in a table called "orders"
            # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

            $post_data = array();
            $post_data['total_amount'] = $request->input('total_price'); # You cant not pay less than 10
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = uniqid(); // tran_id must be unique

            $post_data['success_url'] = "http://localhost:3000";
            $post_data['fail_url'] = "http://localhost:3000";
            $post_data['cancel_url'] = "http://localhost:3000";

            # CUSTOMER INFORMATION
            $post_data['cus_name'] = $request->input('patient_name');
            $post_data['cus_email'] = strtolower($request->input('patient_name')).'@gmail.com';
            //$post_data['cus_email'] = 'patient@mail.com';
            $post_data['cus_add1'] = 'Customer Address';
            $post_data['cus_add2'] = "";
            $post_data['cus_city'] = "";
            $post_data['cus_state'] = "";
            $post_data['cus_postcode'] = "";
            $post_data['cus_country'] = "Bangladesh";
            $post_data['cus_phone'] = $request->input('phone_number');
            $post_data['cus_fax'] = "";

            # SHIPMENT INFORMATION
            $post_data['ship_name'] = "United Hospital";
            $post_data['ship_add1'] = "Dhaka";
            $post_data['ship_add2'] = "Dhaka";
            $post_data['ship_city'] = "Dhaka";
            $post_data['ship_state'] = "Dhaka";
            $post_data['ship_postcode'] = "1000";
            $post_data['ship_phone'] = "";
            $post_data['ship_country'] = "Bangladesh";

            $post_data['shipping_method'] = "NO";
            $post_data['product_name'] = "Doctor Appointemnt";
            $post_data['product_category'] = "physical";
            $post_data['product_profile'] = "physical-goods";

            # OPTIONAL PARAMETERS
            /*$post_data['value_a'] = "ref001";
            $post_data['value_b'] = "ref002";
            $post_data['value_c'] = "ref003";
            $post_data['value_d'] = "ref004";*/
            $post_data['appointment_id'] = $request->input('appointment_id');
            $post_data['appointment_date'] = $request->input('appointment_date');
            $post_data['appointment_time'] = $request->input('appointment_time');
            $post_data['patient_id'] = $request->input('patient_id');
            $post_data['doctor_name'] = $request->input('doctor_name');
            $post_data['doctor_id'] = $request->input('doctor_id');
            $post_data['doctor_fees'] = $request->input('doctor_fees');
            $post_data['registration_fees'] = $request->input('registration_fees');


            #Before  going to initiate the payment order status need to update as Pending.
            $update_product = DB::table('orders')
                ->where('transaction_id', $post_data['tran_id'])
                ->updateOrInsert([
                    'doctor_id' => $post_data['doctor_id'],
                    'patient_id' => $post_data['patient_id'],
                    'appointment_id' => $post_data['appointment_id'],
                    'appointment_date' => $post_data['appointment_date'],
                    'appointment_time' => $post_data['appointment_time'],
                    'patient_phone_number' => $post_data['cus_phone'],
                    'amount' => $post_data['total_amount'],
                    'doctor_name' => $post_data['doctor_name'],
                    'patient_name' => $post_data['cus_name'],
                    'doctor_fees' => $post_data['doctor_fees'],
                    'registration_fees' => $post_data['registration_fees'],
                    'status' => 'Pending',
                    'transaction_id' => $post_data['tran_id'],
                    'currency' => $post_data['currency']
                ]);

            $sslc = new SslCommerzNotification();
            # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
            $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

            if (!is_array($payment_options)) {
                print_r($payment_options);
                $payment_options = array();
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
    public function getPaymentDetails(Request $request){
        try{
            $payment_data = DB::table('orders')->where('transaction_id', $request->input('transaction_id'))->first();
            if($payment_data){
                return response()->json(['status'=>true,'message'=>'Payment data','error'=>'','data'=>$payment_data], 200);
            } else {
                return response()->json(['status'=>false,'message'=>'Payment data not found','error'=>'','data'=>''], 200);
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
    public function UpdateAppoinmentDetails(Request $request){
        try{
            $Input = [];
            $Input['appointment_id'] = $request->input('appointment_id');
            $Input['appointment_date'] = $request->input('appointment_date');
            $Input['appointment_time'] = $request->input('appointment_time');
            $payment_data = DB::table('orders')->where('transaction_id', $request->input('transaction_id'))->update($Input);
            if($payment_data){
                $get_payment_data = DB::table('orders')->where('transaction_id', $request->input('transaction_id'))->first();
                return response()->json(['status'=>true,'message'=>'Payment data','error'=>'','data'=>$get_payment_data], 200);
            } else {
                return response()->json(['status'=>false,'message'=>'Payment data not found','error'=>'','data'=>''], 200);
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
    public function getUserPaymentDetails(Request $request){
        try{
            $payment_data = DB::table('orders')->where('patient_id', $request->input('patient_id'))->first();
            if($payment_data){
                return response()->json(['status'=>true,'message'=>'Payment data','error'=>'','data'=>$payment_data], 200);
            } else {
                return response()->json(['status'=>false,'message'=>'Payment data not found','error'=>'','data'=>''], 200);
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
