<?php

namespace App\Http\Controllers\v1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\v1\Api\FieldMonitorRequest;
use App\Models\FieldMonitoring;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\v1\Api\BaseController as BaseController;
use App\Models\Inspection;
use App\Models\InspectionImage;

class FieldMonitorController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = FieldMonitoring::with('officer','department')->orderby('id', "desc")->get();
        return $this->handleResponse($fields, 'Success!');

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
    public function store(FieldMonitorRequest $request)
    {
        $field = new FieldMonitoring();
        $field->title = $request->title;
        $field->zone = $request->zone;
        $field->circle = $request->circle;
        $field->officer = $request->officer;
        $field->department = $request->department;
        $field->description = $request->description;
        $field->distance = '5 km';
        $field->latitude = $request->latitude;
        $field->longitude = $request->longitude;
        $field->save();

        $success['field_monitoring'] =  $field;

        return $this->handleResponse($success, 'Field Monitoring details has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = FieldMonitoring::with('officer','department')->where('id',$id)->first();
        return $this->handleResponse($field, 'Field Monitoring details get successfully!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FieldMonitorRequest $request, $id)
    {
        $field = FieldMonitoring::find($id);
        $field->title = $request->title;
        $field->zone = $request->zone;
        $field->circle = $request->circle;
        $field->officer = $request->officer;
        $field->department = $request->department;
        $field->description = $request->description;
        $field->save();

        $success['field_monitoring'] =  $field;

        return $this->handleResponse($success, 'Field Monitoring details has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {       
        $inspection = Inspection::where('monitoring_id',$id)->get();
        foreach($inspection as $ins){
            $image = InspectionImage::where("inspection_id",$ins->id)->get();
            foreach($image as $i){
                if($i->image != ""){
                    $image_path = explode("storage/", $i->image);
                    $url = storage_path('app/public/').''.$image_path[1];
                    if(file_exists($url)){
                        unlink($url);
                    }                    
                }  
            }
            $image_delete = InspectionImage::where('inspection_id',$ins->id)->delete();
        } 
        $delete = FieldMonitoring::where('id',$id)->delete();
        $inspection_delete = Inspection::where('monitoring_id',$id)->delete();
        return $this->handleResponse([], 'Field Monitoring details deleted successfuly!');
    }
}
