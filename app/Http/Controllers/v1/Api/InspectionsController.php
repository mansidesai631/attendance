<?php

namespace App\Http\Controllers\v1\Api;

use App\Http\Controllers\v1\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Inspection;
use App\Models\InspectionImage;
use App\Models\InspectionRemark;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\v1\Api\InspectionRequest;

class InspectionsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $inspections = Inspection::where('monitoring_id',$request->id)->get();
        foreach($inspections as $inspection){
            $inspection['before_image'] = $inspection->beforeImages()->get();
            $inspection['after_image'] = $inspection->afterImages()->get();
            $inspection['remarks'] = $inspection->inspectionRemarks()->get();
            array_push($data, $inspection);
        }        
        return $this->handleResponse($data, 'Inspection details get successfully!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InspectionRequest $request)
    {
        $inspection = new Inspection;
        $inspection->monitoring_id = $request->monitoring_id;
        $inspection->title = $request->title;
        $inspection->before_note = $request->before_note;
        $inspection->before_lat = $request->before_lat;
        $inspection->before_long = $request->before_long;
        $inspection->after_note = $request->after_note;
        $inspection->after_lat = $request->after_lat;
        $inspection->after_long = $request->after_long;
        // $inspection->remark = $request->remark;
        $inspection->save();

        if($inspection->id > 0) {
            if($request->remark) {
                $inspectionRemark = new InspectionRemark();
                $inspectionRemark->inspection_id = $inspection->id;
                $inspectionRemark->remark = $request->remark;
                $inspectionRemark->created_by = Auth::id();
                $inspection->inspectionRemarks()->save($inspectionRemark);
            }

            if($request->has('before_images')) {
                for($i=0; $i<count($request->all()['before_images']); $i++) {
                    $filePath = "";
                    if(isset($request->all()['before_images'][$i]) && !empty($request->all()['before_images'][$i])) {
                        $filePath = $request->file('before_images.'.$i)->storeAs(
                            'inspectionImage',
                            random_int(100000, 999999).'.'.$request->file('before_images.'.$i)->extension(),
                            'public'
                        );
                        
                    }
                    $inspectionImage = new InspectionImage([
                        'image_type' => 'Before',
                        'image' => ($filePath != "")? $filePath : NULL
                    ]);
                    $inspection->inspectionImages()->save($inspectionImage);
                }
            }
            if($request->has('after_images')) {
                for($i=0; $i<count($request->all()['after_images']); $i++) {
                    $filePath = "";
                    if(isset($request->all()['after_images'][$i]) && !empty($request->all()['after_images'][$i])) {
                        $filePath = $request->file('after_images.'.$i)->storeAs(
                            'inspectionImage',
                            random_int(100000, 999999).'.'.$request->file('after_images.'.$i)->extension(),
                            'public'
                        );
                        
                    }
                    $inspectionImage = new InspectionImage([
                        'image_type' => 'After',
                        'image' => ($filePath != "")? $filePath : NULL
                    ]);
                    $inspection->inspectionImages()->save($inspectionImage);
                }
            }
        }

        $success['inspection'] =  $inspection;
        return $this->handleResponse($success, 'Inspection has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inspection = Inspection::with('inspectionImages', 'inspectionRemarks')->where('id',$id)->first();
        return $this->handleResponse($inspection, 'Inspection detail show successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InspectionRequest $request, $id)
    {
        $inspection = Inspection::find($id);
        $inspection->monitoring_id = $request->monitoring_id;
        $inspection->title = $request->title;
        $inspection->before_note = $request->before_note;
        $inspection->before_lat = $request->before_lat;
        $inspection->before_long = $request->before_long;
        $inspection->after_note = $request->after_note;
        $inspection->after_lat = $request->after_lat;
        $inspection->after_long = $request->after_long;
        // $inspection->remark = $request->remark;
        $inspection->save();

        if($inspection->id > 0) {
            if($request->has('before_images')) {
                if(count($request->all()['before_images']) > 0) {
                    $images = InspectionImage::where("inspection_id", $inspection->id)->where('image_type', 'Before')->get();
                    foreach($images as $i){
                        if($i->image != ""){
                            $image_path = explode("storage/", $i->image);
                            $url = storage_path('app/public/').''.$image_path[1];
                            if(file_exists($url)){
                                unlink($url);
                            }                    
                        }  
                    }
                    $inspection->beforeImages()->delete();
                }
                for($i=0; $i<count($request->all()['before_images']); $i++) {
                    $filePath = "";
                    if(isset($request->all()['before_images'][$i]) && !empty($request->all()['before_images'][$i])) {
                        $filePath = $request->file('before_images.'.$i)->storeAs(
                            'inspectionImage',
                            random_int(100000, 999999).'.'.$request->file('before_images.'.$i)->extension(),
                            'public'
                        );
                        
                    }
                    $inspectionImage = new InspectionImage([
                        'image_type' => 'Before',
                        'image' => ($filePath != "")? $filePath : NULL
                    ]);
                    $inspection->inspectionImages()->save($inspectionImage);
                }
            }

            if($request->has('after_images')) {
                if(count($request->all()['after_images']) > 0) {
                    $images = InspectionImage::where("inspection_id", $inspection->id)->where('image_type', 'After')->get();
                    foreach($images as $i){
                        if($i->image != ""){
                            $image_path = explode("storage/", $i->image);
                            $url = storage_path('app/public/').''.$image_path[1];
                            if(file_exists($url)){
                                unlink($url);
                            }                    
                        }  
                    }
                    $inspection->afterImages()->delete();
                }
                for($i=0; $i<count($request->all()['after_images']); $i++) {
                    $filePath = "";
                    if(isset($request->all()['after_images'][$i]) && !empty($request->all()['after_images'][$i])) {
                        $filePath = $request->file('after_images.'.$i)->storeAs(
                            'inspectionImage',
                            random_int(100000, 999999).'.'.$request->file('after_images.'.$i)->extension(),
                            'public'
                        );
                        
                    }
                    $inspectionImage = new InspectionImage([
                        'image_type' => 'After',
                        'image' => ($filePath != "")? $filePath : NULL
                    ]);
                    $inspection->inspectionImages()->save($inspectionImage);
                }
            }
        }

        $success['inspection'] =  $inspection;
        return $this->handleResponse($success, 'Inspection has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inspection = Inspection::find($id);
        if($inspection) {
            $images = InspectionImage::where("inspection_id", $id)->get();
            foreach($images as $i){
                if($i->image != ""){
                    $image_path = explode("storage/", $i->image);
                    $url = storage_path('app/public/').''.$image_path[1];
                    if(file_exists($url)){
                        unlink($url);
                    }                    
                }  
            }
        
            $inspection->inspectionImages()->delete();
            $inspection->inspectionRemarks()->delete();
            $inspection->delete();

            return $this->handleResponse([], 'Inspection details deleted successfuly!');
        } else{
            return $this->handleError('Inspection not found!');
        }
    }

    public function saveRemark(Request $request){
        $id = $request->inspection_id;
        $inspectionRemark = new InspectionRemark();
        $inspectionRemark->inspection_id = $id;
        $inspectionRemark->remark = $request->remark;
        $inspectionRemark->created_by = Auth::id();
        $inspectionRemark->save();
        return $this->handleResponse($inspectionRemark,'Remark stored successfully!');
    }
}
