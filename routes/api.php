<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
//Route::group(['namespace' => 'Dashboard', 'middleware' => ['auth:web','checkAdmin'], 'prefix' => 'dashboard'], function () {
Route::group(['middleware' => ['api']], function () {
    Route::post('register', [App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('patient-register', [App\Http\Controllers\Api\AuthController::class, 'Paitentregister']);
    Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::post('forgetpassword', [App\Http\Controllers\Api\AuthController::class, 'forgetpassword']);
    Route::post('resetpassword', [App\Http\Controllers\Api\AuthController::class, 'Resetpassword']);
    Route::get('reset/password/{email}', [App\Http\Controllers\Api\AuthController::class, 'passwordReset']);
    Route::post('/account/activation/{active_code}', [App\Http\Controllers\Api\AuthController::class, 'userActivation']);
    Route::post('/checkuserpatientid', [App\Http\Controllers\Api\AuthController::class, 'checkUserPatientId']);
    /*Route::get('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::post('/refresh', [App\Http\Controllers\Api\AuthController::class, 'refresh']);
    Route::get('/test_api', [App\Http\Controllers\Api\AuthController::class, 'test_api']);*/
    
    Route::get('/emergency', [App\Http\Controllers\Api\EmergencyController::class, 'postEmergencyCase']);


});
Route::group(['middleware' => ['api'], 'prefix' => 'user'], function ($router) {
  Route::get('detail/{id}', [App\Http\Controllers\Api\UserController::class, 'getuserDetails']);
  Route::post('saveotpnumber', [App\Http\Controllers\Api\UserController::class, 'SaveOTPNumber']);
  Route::post('sendotp', [App\Http\Controllers\Api\UserController::class, 'SendOTP']);
  Route::get('getotpdata', [App\Http\Controllers\Api\UserController::class, 'getOTPData']);
  Route::post('resetotpdata', [App\Http\Controllers\Api\UserController::class, 'ResetOTPData']);
  Route::post('updatepatientid', [App\Http\Controllers\Api\UserController::class, 'UpdatePatientId']);
  /*Route::post('checkemail', 'Api\UserController@checkemail');
  Route::post('checkusername', 'Api\UserController@checkusername');
  Route::get('role', 'Api\UserController@getuserRole');*/

});

Route::group(['middleware' => ['api','jwt.verify'], 'prefix' => 'user'], function() {
  Route::post('checkuserlogin', 'Api\UserController@checkuserlogin');
});

Route::group(['middleware' => ['api'], 'prefix' => 'department'], function ($router) {
    Route::get('/getalldepartments', [App\Http\Controllers\Api\DepartmentController::class, 'getAllDepartments']);
    Route::get('/adminsearchdepartments', [App\Http\Controllers\Api\DepartmentController::class, 'AdminSearchDepartments']);
    Route::get('/getdepartments', [App\Http\Controllers\Api\DepartmentController::class, 'getDepartments']);
    Route::post('/createdepartment', [App\Http\Controllers\Api\DepartmentController::class, 'CreateDepartments']);
    Route::get('/getsingledepartment/{id}', [App\Http\Controllers\Api\DepartmentController::class, 'GetSingleDepartment']);
    Route::post('/updatedepartment/{id}', [App\Http\Controllers\Api\DepartmentController::class, 'UpdateDepartment']);
    Route::post('/deletedepartment', [App\Http\Controllers\Api\DepartmentController::class, 'deleteDepartment']);
    Route::get('/checkdepartmentidduplicate', [App\Http\Controllers\Api\DepartmentController::class, 'checkDepartmentIdDuplicate']);
});

Route::group(['middleware' => ['api'], 'prefix' => 'homesetting'], function ($router) {
    Route::post('/savehomesetting', [App\Http\Controllers\Api\HomePageController::class, 'SaveHomeSetting']);
    Route::get('/getdefaultsearchdata', [App\Http\Controllers\Api\HomePageController::class, 'getDefaultSearchData']);
    Route::get('/getsearchdata', [App\Http\Controllers\Api\HomePageController::class, 'getSearchData']);
});

Route::group(['middleware' => ['api'], 'prefix' => 'bodypart'], function ($router) {
    Route::get('/getbodypartdepartment', [App\Http\Controllers\Api\HomePageController::class, 'getBodyPartDepartments']);
    Route::get('/getbodypartdepartmentdoctors', [App\Http\Controllers\Api\HomePageController::class, 'getBodyPartDepartmentsDoctors']);
    Route::get('/getallbodyparts', [App\Http\Controllers\Api\HomePageController::class, 'getAllBodyParts']);
});

Route::group(['middleware' => ['api'], 'prefix' => 'testimonials'], function ($router) {
    Route::post('/savetestimonials', [App\Http\Controllers\Api\TestimonialsController::class, 'SaveTestimonials']);
    Route::get('/getalltestimonials', [App\Http\Controllers\Api\TestimonialsController::class, 'GetAllTestimonials']);
    Route::get('/adminsearchtestimonials', [App\Http\Controllers\Api\TestimonialsController::class, 'AdminSearchTestimonials']);
    Route::get('/getsingletestimonials/{id}', [App\Http\Controllers\Api\TestimonialsController::class, 'GetSingleTestimonials']);
    Route::post('/updatetestimonials/{id}', [App\Http\Controllers\Api\TestimonialsController::class, 'UpdateTestimonials']);
    Route::post('/deletetestimonials', [App\Http\Controllers\Api\TestimonialsController::class, 'deleteTestimonials']);
     Route::get('/getdoctortestimonials', [App\Http\Controllers\Api\TestimonialsController::class, 'GetDoctorTestimonials']);
});

Route::group(['middleware' => ['api'], 'prefix' => 'newsevents'], function ($router) {
    Route::post('/savenewsevents', [App\Http\Controllers\Api\NewsEventsController::class, 'SaveNewsEvents']);
    Route::get('/getallnewsevents', [App\Http\Controllers\Api\NewsEventsController::class, 'GetAllNewsEvents']);
    Route::get('/adminsearchnewsevents', [App\Http\Controllers\Api\NewsEventsController::class, 'AdminSearchNewsEvents']);
    Route::get('/getnewsevents', [App\Http\Controllers\Api\NewsEventsController::class, 'GetNewsEvents']);
    Route::get('/getsinglenewsevents/{id}', [App\Http\Controllers\Api\NewsEventsController::class, 'GetSingleNewsEvents']);
    Route::post('/updatenewsevents/{id}', [App\Http\Controllers\Api\NewsEventsController::class, 'UpdateNewsEvents']);
    Route::post('/deletenewsevents', [App\Http\Controllers\Api\NewsEventsController::class, 'deleteNewsEvents']);
});

Route::group(['middleware' => ['api'], 'prefix' => 'publications'], function ($router) {
    Route::post('/savepublications', [App\Http\Controllers\Api\PublicationsController::class, 'SavePublications']);
    Route::get('/getallpublications', [App\Http\Controllers\Api\PublicationsController::class, 'GetAllPublications']);
    Route::get('/adminsearchpublications', [App\Http\Controllers\Api\PublicationsController::class, 'AdminSearchPublications']);
    Route::get('/getpublications', [App\Http\Controllers\Api\PublicationsController::class, 'GetPublications']);
    Route::get('/getsinglepublications/{id}', [App\Http\Controllers\Api\PublicationsController::class, 'GetSinglePublications']);
    Route::get('/getdoctorpublications/{name}', [App\Http\Controllers\Api\PublicationsController::class, 'GetDoctorPublications']);
    Route::post('/updatepublications/{id}', [App\Http\Controllers\Api\PublicationsController::class, 'UpdatePublications']);
    Route::post('/deletepublications', [App\Http\Controllers\Api\PublicationsController::class, 'deletePublications']);
     Route::get('/getdoctors', [App\Http\Controllers\Api\PublicationsController::class, 'GetDoctors']);
});

Route::group(['middleware' => ['api'], 'prefix' => 'doctors'], function ($router) {
    Route::get('/searchdoctors', [App\Http\Controllers\Api\DoctorsController::class, 'SearchDoctors']);
    Route::get('/adminsearchdoctors', [App\Http\Controllers\Api\DoctorsController::class, 'AdminSearchDoctors']);
    Route::get('/getsingledoctors/{id}', [App\Http\Controllers\Api\DoctorsController::class, 'GetSingleDoctors']);
    Route::get('/getsingledoctorprofiledata/{name}', [App\Http\Controllers\Api\DoctorsController::class, 'GetSingleDoctorProfileData']);
    Route::get('/getalldoctors', [App\Http\Controllers\Api\DoctorsController::class, 'GetAllDoctors']);
    Route::get('/getdoctors', [App\Http\Controllers\Api\DoctorsController::class, 'GetDoctors']);
    Route::post('/createdoctor', [App\Http\Controllers\Api\DoctorsController::class, 'CreateDoctor']);
    Route::post('/updatedoctor/{id}', [App\Http\Controllers\Api\DoctorsController::class, 'UpdateDoctor']);
    Route::post('/deletedoctor', [App\Http\Controllers\Api\DoctorsController::class, 'deleteDoctor']);
    Route::get('/getdoctorsbydepartment/{id}', [App\Http\Controllers\Api\DoctorsController::class, 'GetDoctorsByDepartment']);
});

Route::group(['middleware' => ['api'], 'prefix' => 'packages'], function ($router) {
    
    Route::get('/getallpackages', [App\Http\Controllers\Api\PackagesController::class, 'GetAllPackages']);
    Route::post('/deletepackage', [App\Http\Controllers\Api\PackagesController::class, 'deletePackage']);
    Route::get('/getallprecondtion', [App\Http\Controllers\Api\PackagesController::class, 'getAllPreCondtion']);
    Route::post('/createpackage', [App\Http\Controllers\Api\PackagesController::class, 'CreatePackage']);
    Route::get('/getsinglepackagedata/{id}', [App\Http\Controllers\Api\PackagesController::class, 'GetSinglePackageData']);
    Route::post('/updatepackage/{id}', [App\Http\Controllers\Api\PackagesController::class, 'UpdatePackage']);
    Route::get('/getsinglepackagedetails/{id}', [App\Http\Controllers\Api\PackagesController::class, 'GetSinglePackageDetails']);
    Route::get('/adminsearchPackage', [App\Http\Controllers\Api\PackagesController::class, 'AdminSearchPackage']);
    Route::get('/getsearchpackagedata', [App\Http\Controllers\Api\PackagesController::class, 'getSearchPackageData']);
     
});

Route::group(['middleware' => ['api'], 'prefix' => 'staticpages'], function ($router) {
    
    Route::get('/getallstaticpages', [App\Http\Controllers\Api\StaticPagesController::class, 'GetAllStaticPages']);
    Route::post('/deletestaticpages', [App\Http\Controllers\Api\StaticPagesController::class, 'deleteStaticPages']);
    Route::post('/createstaticpage', [App\Http\Controllers\Api\StaticPagesController::class, 'CreateStaticPage']);
    Route::get('/getsinglestaticpage/{title}', [App\Http\Controllers\Api\StaticPagesController::class, 'GetSingleStaticPage']);
    Route::post('/updatestaticpage/{id}', [App\Http\Controllers\Api\StaticPagesController::class, 'UpdateStaticPage']);
    Route::get('/adminsearchstaticpage', [App\Http\Controllers\Api\StaticPagesController::class, 'AdminSearchStaticpage']);

    Route::get('/getstaticpages', [App\Http\Controllers\Api\StaticPagesController::class, 'GetStaticPages']);
    Route::get('/getsinglestaticpageslugdata/{slug}', [App\Http\Controllers\Api\StaticPagesController::class, 'GetSingleStaticPageSlugData']);
  
});


Route::group(['middleware' => ['api'], 'prefix' => 'menu'], function ($router) {
    Route::get('/getallmenu', [App\Http\Controllers\Api\MenuController::class, 'GetAllMenu']);
    Route::post('/deletemenu', [App\Http\Controllers\Api\MenuController::class, 'deleteMenu']);
    Route::post('/createmenu', [App\Http\Controllers\Api\MenuController::class, 'CreateMenu']);
    Route::get('/getsinglemenu/{title}', [App\Http\Controllers\Api\MenuController::class, 'GetSingleMenu']);
    Route::post('/updatemenu/{id}', [App\Http\Controllers\Api\MenuController::class, 'UpdateMenu']);
    Route::get('/adminsearchmenu', [App\Http\Controllers\Api\MenuController::class, 'AdminSearchMenu']);
});

Route::group(['middleware' => ['api'], 'prefix' => 'bannerbutton'], function ($router) {
    Route::post('/savebannerbtndata', [App\Http\Controllers\Api\BannerButtonLinkController::class, 'SaveBannerButtonLink']);
    Route::get('/getallbannerbtndata', [App\Http\Controllers\Api\BannerButtonLinkController::class, 'GetAllBannerButtonLink']);
    Route::get('/getsinglebannerbtndata/{id}', [App\Http\Controllers\Api\BannerButtonLinkController::class, 'GetSingleBannerButtonLinkData']);
    Route::post('/updatebannerbtndata/{id}', [App\Http\Controllers\Api\BannerButtonLinkController::class, 'UpdateBannerButtonLink']);
    Route::post('/deletebannerbtnlink', [App\Http\Controllers\Api\BannerButtonLinkController::class, 'deleteBannerButtonLink']);
});

Route::group(['middleware' => ['api'], 'prefix' => 'payment'], function ($router) {
    Route::post('/pay', [App\Http\Controllers\Api\SslCommerzPaymentController::class, 'index']);
    Route::post('/pay-via-ajax', [App\Http\Controllers\Api\SslCommerzPaymentController::class, 'payViaAjax']);

    Route::post('/success', [App\Http\Controllers\Api\SslCommerzPaymentController::class, 'success']);
    Route::post('/fail', [App\Http\Controllers\Api\SslCommerzPaymentController::class, 'fail']);
    Route::post('/cancel', [App\Http\Controllers\Api\SslCommerzPaymentController::class, 'cancel']);

    Route::post('/ipn', [App\Http\Controllers\Api\SslCommerzPaymentController::class, 'ipn']);

    Route::get('/getpaymentdetails', [App\Http\Controllers\Api\SslCommerzPaymentController::class, 'getPaymentDetails']);
    Route::get('/getuserpaymentdetails', [App\Http\Controllers\Api\SslCommerzPaymentController::class, 'getUserPaymentDetails']);
    Route::post('/updateappointemntdetails', [App\Http\Controllers\Api\SslCommerzPaymentController::class, 'UpdateAppoinmentDetails']);
});

Route::group(['middleware' => ['api'], 'prefix' => 'payments'], function ($router) {
    Route::post('/getSessionGatewayUrl', [App\Http\Controllers\Api\SslCommerzPaymentApiController::class, 'getSession']);
    /*Route::post('/pay', [App\Http\Controllers\Api\SslCommerzPaymentApiController::class, 'index']);*/
    /*Route::post('/pay-via-ajax', [App\Http\Controllers\Api\SslCommerzPaymentApiController::class, 'payViaAjax']);

    Route::post('/success', [App\Http\Controllers\Api\SslCommerzPaymentApiController::class, 'success']);
    Route::post('/fail', [App\Http\Controllers\Api\SslCommerzPaymentApiController::class, 'fail']);
    Route::post('/cancel', [App\Http\Controllers\Api\SslCommerzPaymentApiController::class, 'cancel']);

    Route::post('/ipn', [App\Http\Controllers\Api\SslCommerzPaymentController::class, 'ipn']);*/
});

// BodyLinkDept...
Route::group(['middleware' => ['api'], 'prefix' => 'bodylink'], function ($router) {
    Route::get('/getallbodylink', [App\Http\Controllers\Api\BodyPartsDepartController::class, 'getAllBodyLink']);
    Route::get('/getbodyparts/{gender}',[App\Http\Controllers\Api\BodyPartsDepartController::class, 'getBodyParts']);
    Route::post('/createbodyparts',[App\Http\Controllers\Api\BodyPartsDepartController::class, 'CreateBodyParts']);
    Route::get('/deletebodylinks', [App\Http\Controllers\Api\BodyPartsDepartController::class, 'deletebodylinks']);
    Route::get('/getsinglepagedata/{id}', [App\Http\Controllers\Api\BodyPartsDepartController::class, 'GetSinglePageData']);
    Route::post('/updatebodylink/{id}', [App\Http\Controllers\Api\BodyPartsDepartController::class, 'UpdateBodyLink']);
    Route::get('/editbodylink/{id}', [App\Http\Controllers\Api\BodyPartsDepartController::class, 'EditBodyLink']);
    Route::get('/getsearchdata', [App\Http\Controllers\Api\BodyPartsDepartController::class, 'AdminSearchData']);
});

Route::group(['middleware' => ['api'], 'prefix' => 'headerannoucement'], function ($router) {
    Route::get('/getallheaderannoucement', [App\Http\Controllers\Api\HomeSettingController::class, 'GetAllHeaderAnnoucement']);
    Route::get('/getsingleheaderannoucement/{id}', [App\Http\Controllers\Api\HomeSettingController::class, 'GetSingleHeaderAnnoucement']);
    Route::post('/saveheaderannoucement',[App\Http\Controllers\Api\HomeSettingController::class, 'CreateHeaderAnnoucement']);
    Route::post('/updateheaderannoucement/{id}', [App\Http\Controllers\Api\HomeSettingController::class, 'UpdateHeaderAnnoucement']);
});

Route::group(['middleware' => ['api','jwt.verify'],'prefix' => 'errorlog'], function(){
    Route::get('lists', 'Api\ErrorLogController@errorLists');
    Route::post('search', 'Api\ErrorLogController@errorSearch');
    Route::get('detail/{id}', 'Api\ErrorLogController@geterrorDetails');
});

Route::group(['middleware' => ['api'],'prefix' => 'emergency'], function(){
    Route::post('case', [App\Http\Controllers\Api\EmergencyController::class, 'postEmergencyCase']);
});


