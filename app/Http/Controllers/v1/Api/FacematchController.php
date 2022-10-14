<?php

namespace App\Http\Controllers\v1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\v1\Api\BaseController as BaseController;
use App\Models\EmployeeWork;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveList;
use Illuminate\Support\Carbon;
use App\Helpers\Helper;
use URL;
use Log;
use App\Http\Requests\v1\Api\ProfileRequest;
use Illuminate\Support\Facades\DB;

class FacematchController extends BaseController
{
    public function userInfo(Request $request){

        $rules = [
            'latitude' => 'required',
            'longitude' => 'required',
            'time' => 'required',
            'image_url' => 'required',
            'flag' => 'required',
        ];

        $image = $request->image_url;

       $decoded = base64_decode($image);

        $attdanceImage = date("h.iA").'faceimage.jpg';
        file_put_contents($attdanceImage, $decoded);

        // $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        // $txt = $request->image_url;
        // fwrite($myfile, $txt);
        // fclose($myfile);


        $msg = [
            'latitude.required' => 'Latitude is required.',
            'longitude.required' => 'Longitude is required.',
            'time.required' => 'Time is required.',
            'image_url.required' => 'Image not found.',
            'flag.required' => 'Flag is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $msg);

        if ($validator->fails()) {
            return $this->handleError($validator->errors());
        }

        $latitude = request('latitude','23.022505');
        $longitude= request('longitude','72.5713621');
        //$time = request('time',date('HH:mm'));
        //$new_time = date("H:i", strtotime('+5 hours 30 minutes'));
        $time = date('H:i', strtotime('+5 hours 30 minutes'));


      //  $existing_data_check = Attendance::where('employee_id',$request->employee_id)->whereDate('created_at',date('Y-m-d'))->first();

        // if($existing_data_check){
        //      return $this->handleError('You are not able add attendance today, please try again.');
        // }

        ini_set('max_execution_time', 5000);
        if($request->employee_id){
            $employee = Employee::find($request->employee_id);
            if(!$employee){

                return $this->handleError('Employee not found.');
            }elseif(is_null($employee->register_face)){
                return $this->handleResponse($employee->register_face,'Employee image not found!!');
            }
            elseif($employee->register_face){
                if($employee->access->ad_allowed_location && $employee->access->attendance_location_id){
                    $location_distance = DB::select('select *, round( ( 3959 * acos( least(1.0, cos( radians(' . $latitude . ') )
                    * cos( radians(latitude) )
                    * cos( radians(longitude) - radians(' . $longitude . ') )
                    + sin( radians(' . $latitude . ') ) * sin( radians(latitude) ) ) ) ), 1)
                    * 100 as distance from locations where id = ' . $employee->access->attendance_location_id . ' having distance <= radius');
                    if(!$location_distance){
                        return $this->handleError('You are not in your zone, please try again.');
                    }
                }

               // $encoded_image1 = base64_encode(file_get_contents(storage_path('app/public/registerFace/'.$employee->register_face)));
              $encoded_image1 = storage_path('app/public/registerFace/').''.$employee->register_face;
               $encoded_image2 = $attdanceImage;


               $img1 = "http://205.134.254.135/~amcapp/attendance-system/public/storage/registerFace/$employee->register_face";

               $img2 =  "http://205.134.254.135/~amcapp/attendance-system/public/$attdanceImage";

                $result = $this->matchFaceEmployee($img1, $img2);

            }
        }else{
            $employees = Employee::orderBy('id','DESC')->paginate(20);
            foreach($employees as $employee){
                if(!is_null($employee->register_face)){
                    if($employee->access->ad_allowed_location && $employee->access->attendance_location_id){
                        $location_distance = DB::select('select *, round( ( 3959 * acos( least(1.0, cos( radians(' . $latitude . ') )
                        * cos( radians(latitude) )
                        * cos( radians(longitude) - radians(' . $longitude . ') )
                        + sin( radians(' . $latitude . ') ) * sin( radians(latitude) ) ) ) ), 1)
                        * 100 as distance from locations where id = ' . $employee->access->attendance_location_id . ' having distance <= radius');
                        if(!$location_distance){
                            return $this->handleError('You are not in your zone, please try again.');
                        }
                    }
                    $encoded_image1 = base64_encode(file_get_contents(storage_path('app/public/registerFace/'.$employee->register_face)));

                    $encoded_image2 = request('image_url');

                     $img1 = "http://205.134.254.135/~amcapp/attendance-system/public/storage/registerFace/$employee->register_face";

               $img2 =  "http://205.134.254.135/~amcapp/attendance-system/public/$encoded_image2";


                    $result = $this->matchFaceEmployee($img1, $img2);

                    if($result > 70){
                        break;
                    }
                }
            }
        }

        if($result != 0){
            $existing_data = Attendance::where('employee_id',$employee['id'])->whereDate('created_at',date('Y-m-d'))->first();
            if($request->flag == 'in'){
                if(!$existing_data){
                    Attendance::create(
                    [
                        'employee_id'=>$employee['id'],
                        'joining_date'=>$employee['work']['joining_date'],
                        'in_time'=>$time,
                        'in_latitude'=>$latitude,
                        'in_longitude'=>$longitude,
                        'out_time'=>Null,
                        'attendance_from'=>'Mobile',
                        'create_by'=>'1',
                    ]);
                }else{
                    if($existing_data->out_time){
                        $existing_data->update(['in_time'=>$time, 'out_time'=>Null, 'in_latitude'=>$latitude,
                        'in_longitude'=>$longitude]);
                    } else{
                        return $this->handleError('You are already In.');
                    }
                }

                return $this->handleResponse($employee, 'Your attendance in time added successfully!');
            }else{
                if($existing_data){

                    if($existing_data->out_time == Null){
                        $existing_data->update(['out_time'=>$time,'out_latitude'=>$latitude,
                            'out_longitude'=>$longitude]);
                        return $this->handleResponse($employee, 'Your attendance Out time added successfully!');
                    } else {
                        return $this->handleError('You are already Out.');
                    }
                }else{
                    return $this->handleError('Ivalid Action .');
                }
            }
        }else{
            return $this->handleError('Your Photo does not match!');
        }
    }

    public function matchFaceEmployee($encoded_image1, $encoded_image2)
    {
        //subscriptionkey from your mxface dashboard
        $subscriptionkey = env('SUBSCRIPTION_KEY');

        $api_key = "kTt4dN_AdmLvfaIGuSKHMbnqZ7dmOKBP";
        $api_secret = "U2mAly1vMS6MYGP6E1EL4RZc-fujfqno";

        // add image path from local system
        $IMAGE1_PATH =$encoded_image1;
        $IMAGE2_PATH =$encoded_image2;



        function makecUrlFile($file){
            $mime = mime_content_type($file);
            $info = pathinfo($file);
            $name = $info['basename'];
            $output = new \CURLFile($file, $mime, $name);
            return $output;
        }
            $imageObject1 = $IMAGE1_PATH;
            $imageObject2 = $IMAGE2_PATH;


            // $imageObject1 = 'http://205.134.254.135/~amcapp/attendance-system/public/storage/registerFace/registerFace-1658831964.jpg';
            // $imageObject2 = 'http://205.134.254.135/~amcapp/attendance-system/public/storage/registerFace/registerFace-1658831964.jpg';

        $request = curl_init();
            $queryUrl = "https://api-us.faceplusplus.com/facepp/v3/compare"; // face match url
             $imageObject =  array("api_key"=> $api_key,"api_secret" => $api_secret,"image_url1" => $imageObject1, "image_url2" => $imageObject2);

            curl_setopt($request, CURLOPT_URL, $queryUrl);
            curl_setopt($request, CURLOPT_POST, true);
            // curl_setopt($request, CURLOPT_HTTPHEADER, array(
            // "content-type: multipart/form-data",
            // "api_key" . $api_key,
            // "api_secret". $api_secret,


            // )
            // );
            curl_setopt($request,CURLOPT_POSTFIELDS,$imageObject);

            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
           // $response = curl_exec($request);  // curl response
            $response = json_decode(curl_exec($request),true);
            curl_close($request);



        // $entityBody = json_encode([
        //                 'encoded_image1' => $encoded_image1 ,
        //                 'encoded_image2' => $encoded_image2 ,
        //             ]);
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://faceapi.mxface.ai/api/v2/face/verify',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => $entityBody,
        //     CURLOPT_HTTPHEADER => array(
        //         'subscriptionkey:'.$subscriptionkey,
        //         'Content-Type: application/json'
        //     ),
        // ));

       // $response = json_decode(curl_exec($curl),true);
        //curl_close($curl);

        //$statusMatch = $response['data']['status'];
        $statusMatch = $response['confidence'];
        // if(in_array('data',$response)){

        //     Log::debug('error');
        //     $ratio = 0;
        // }else{
            $ratio = 0;
          //  if(array_key_exists('matchedFaces',$response)){

                if($statusMatch > 70 ){
                    $ratio = 80;
                }
        //    }
       // }
        return $ratio;

    }


    public function upgrade(Request $request){

        $app_version = $request->app_version;
        $os_type = $request->os_type;
        $user_id = $request->user_id;

        if($app_version >= 5){
            $version = false;
        }else{
            $version = true;
        }

        if(Auth::user()){
            $user = Auth::user()->id;
        }else{
            $user = $user_id;
        }

        $arr = ['app_version'=>$version,'os_type'=>$os_type,'user_id'=>$user,'isBlockUser'=>'false','isUpdateApp'=>'false'];
        return $this->handleResponse($arr, 'Upgrade app information');
    }


}
