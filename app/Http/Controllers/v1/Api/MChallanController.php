<?php

namespace App\Http\Controllers\v1\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\v1\Api\BaseController as BaseController;
use Validator;
use App\Models\MChallan;
use App\Models\MChallanImage;
use App\Jobs\SentEmailToCreatedMchallan;
use App\Jobs\SentSMSToCreatedMchallan;

class MChallanController extends BaseController
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'concern_officer' => 'required',
            'department' => 'required',
            'name_of_citizen' => 'required|string|max:50',
            'mobile' => 'required|string',
            'id_type' => 'required|string',
            'id_number' => 'required|string',
            'description' => 'required|string',
            'amount_of_fine' => 'required|string',
            'address' => 'required|string|max:255',
            'reason' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'email' => 'required|string',
            'zone' => 'required',
            'ward' => 'required',
            'circle' => 'required',
            // 'image' => [

            //     'image',
            //     function ($attribute, $value, $fail) {
            //         $is_image = Validator::make(
            //             ['image' => $value],
            //             ['image' => 'image']
            //         )->passes();


            //         if (!$is_image) {
            //             $fail(':attribute must be image');
            //         }

            //         if ($is_image) {
            //             $validator = Validator::make(
            //                 ['image' => $value],
            //                 ['image' => "max:1024"]
            //             );
            //             if ($validator->fails()) {
            //                 $fail(":attribute must be one megabyte or less.");
            //             }
            //         }
            //     },
            // ],
            // 'video' => [
            //     'video',
            //     function ($attribute, $value, $fail) {

            //         $is_video = Validator::make(
            //             ['video' => $value],
            //             ['video' => 'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4']
            //         )->passes();

            //         if (!$is_video) {
            //             $fail(':attribute must be video.');
            //         }

            //         if ($is_video) {
            //             $validator = Validator::make(
            //                 ['video' => $value],
            //                 ['video' => "max:102400"]
            //             );
            //             if ($validator->fails()) {
            //                 $fail(":attribute must be 10 megabytes or less.");
            //             }
            //         }

            //     },
            // ],
        ]);

        if($validator->fails()){
            return $this->handleError($validator->errors());
        }
        $mch = new MChallan();
        $mch->concern_officer = $request['concern_officer'];
        $mch->department = $request['department'];
        $mch->name_of_citizen = $request['name_of_citizen'];
        $mch->mobile = trim($request['mobile']);
        $mch->id_type = $request['id_type'];
        $mch->id_number = $request['id_number'];
        $mch->description = $request['description'];
        $mch->amount_of_fine = $request['amount_of_fine'];
        $mch->address = $request['address'];
        $mch->reason = $request['reason'];
        $mch->latitude = $request['latitude'];
        $mch->longitude = $request['longitude'];
        $mch->email = $request['email'];
        $mch->zone  = $request['zone'];
        $mch->ward  = $request['ward'];
        $mch->circle  = $request['circle'];

        $mch->save();

        if($request->hasFile('video')){
            $file = $request['video'];
            $filename = 'mchallan/MChallan-'.time().'.'. $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/mchallan/'), $filename);

            $mchallanVideo = new MChallanImage();
            $mchallanVideo->m_challan_id = $mch->id;
            $mchallanVideo->type = 'video';
            $mchallanVideo->image = ($filename != "")? $filename : NULL;
            $mchallanVideo->save();

        }

        if($request->has('images')) {
            for($i=0; $i<count($request->all()['images']); $i++) {
                $filePath = "";
                if(isset($request->all()['images'][$i]) && !empty($request->all()['images'][$i])) {
                    $filePath = $request->file('images.'.$i)->storeAs(
                        'mchallan',
                        random_int(100000, 999999).'.'.$request->file('images.'.$i)->extension(),
                        'public'
                    );

                }
                $mchallanImages = new MChallanImage();
                $mchallanImages->m_challan_id = $mch->id;
                $mchallanImages->type = 'image';
                $mchallanImages->image = ($filePath != "")? $filePath : NULL;
                $mchallanImages->save();
            }
        }
        if ($mch->id) {

            $data = [];
            $data['id'] = $mch->id;
            $data['m_unique_id'] = $mch->m_unique_id;
            $data['reason'] = $mch->reason;
            $data['mobile'] = $mch->mobile;
            $data['email'] = $mch->email;
            $data['m_no'] = $mch->m_unique_id;
            $data['amount'] = $mch->amount_of_fine;
            //send sms
            // if ($mch->mobile) {
            //     SentSMSToCreatedMchallan::dispatch($data);
            // }
            //send mail
            if ($mch->email) {
                SentEmailToCreatedMchallan::dispatch($data);
            }
        }
        $success['mch'] =  $mch;

        return $this->handleResponse($success, 'MChallan has been added successfully');
    }

    public function getIdType(Request $request)
    {
        $data = [];
        $values = ['Aadhaar', 'PAN', 'Driving License', 'Voter ID', 'Other'];

        foreach ($values as $i => $val) {
            array_push($data, [
                'id' => $i + 1,
                'name' => $val,
            ]);
        }
        return $this->handleResponse($data, 'Get all id type successfully');

    }

    public function getAllChallan(){
        $mChallan = MChallan::with('mChallanImages','employee','department')->orderBy('id', 'desc')->get();
        return $this->handleResponse($mChallan, 'Get all M Challan successfully');

    }
}
