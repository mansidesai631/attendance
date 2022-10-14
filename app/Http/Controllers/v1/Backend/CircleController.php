<?php

namespace App\Http\Controllers\v1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ward;
use DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Circle;

class CircleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $circle  = new Circle();
        $circle->ward_id = @$request->ward_id;
        $circle->circle_name = @$request->circle_name;
        $circle->created_by = Auth::id();
        $circle->save();

        return response()->json(['status' => true,'message' => 'Successfully added!']);
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
        $getCircleData = Circle::with('ward')->find($id);
        return response()->json(['status' => true,'data'=>$getCircleData]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $circle  = Circle::find($request->edit_circle_id);
        $circle->ward_id = @$request->edit_ward_id;
        $circle->circle_name = @$request->edit_circle_name;
        $circle->updated_by = Auth::id();
        $circle->save();

        return response()->json(['status' => true,'message' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete = Circle::where('id',$request->id)->delete();
        return response()->json(['status' => true,'message' => 'Successfully deleted!']);
    }

    public function getAllCircle(Request $request){
        $data = Circle::with('ward');

        if($request->filter_search != ""){
            $data->where(function($q) use ($request) {
                $q->orwhere('circle_name','LIKE',"%".$request->filter_search."%");
                $q->orwhereHas('ward', function($q2) use ($request) {
                    $q2->where('ward_name','LIKE',"%".$request->filter_search."%");
                });
            });
        }

        $data->when(!isset($request->order), function ($q) {
            $q->orderBy('id', 'desc');
        });
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('ward',function($row){
                return @$row->ward->ward_name;
            })
            ->addColumn('action', function($row) {
                $btn = "";
                $btn .= '<button type="button" class="btn btn-link hidden-arrow btn-sm px-2 text-body"
                          data-mdb-toggle="dropdown" aria-expanded="false">
                          <mat-icon class="mat-icon material-icons" aria-hidden="true">more_vert</mat-icon>
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item d-flex align-items-center circle_edit" data-mdb-toggle="modal" data-mdb-target="#edit-circle" data-id="'.$row->id.'">
                              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">edit</mat-icon>
                              <span class="ms-3">Edit</span>
                            </a>
                          </li>';

                $btn .='</ul>';
                return $btn;
            })
            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->rawColumns(['site','action'])
            ->make(true);
    }

    public function getwards(){
        $wards = Ward::all();
        return response()->json(['status' => true,'data' => $wards]);
    }
}
