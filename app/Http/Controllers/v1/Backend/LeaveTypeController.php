<?php

namespace App\Http\Controllers\v1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaveType;
use Illuminate\Support\Str;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('leave-management.leave-type.index');
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
        $checkType = LeaveType::where('name',$request->leave_name)->first();
        if($checkType){
            return response()->json(['status' => false,'message' => 'Leave type already exists!']);
        }

        if($request['leave_code'] == ''){ 
            if($str=trim($request['leave_name']) && strpos($request['leave_name'], ' ') !== false){                
                $explode = explode(' ', $request['leave_name']);                
                $code = strtoupper(substr($explode[0], 0, 1)).''.strtoupper(substr($explode[1], 0, 1));
            }else{;
                $code = $request['leave_name'];
            }
        }else{
            $code = $request->leave_code;
        }
        $leaveType  = new LeaveType();
        $leaveType->name = $request['leave_name'];
        $leaveType->code = $code;
        $leaveType->description = $request['leave_description'];
        $leaveType->created_by = Auth::id();
        $leaveType->save();
        return response()->json(['status' => true,'message' => 'Leave type added successfully!']);
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
        $leaveType = LeaveType::find($id);
        return response()->json(['status' => true,'data'=>$leaveType]);
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
        $checkType = LeaveType::where('name',$request->edit_leave_name)->where('id','!=',$request->leave_type_id)->first();
        if($checkType){
            return response()->json(['status' => false,'message' => 'Leave type already exists!']);
        }
        
        if($request['leave_code'] == ''){ 
            if($str=trim($request['edit_leave_name']) && strpos($request['edit_leave_name'], ' ') !== false){                
                $explode = explode(' ', $request['edit_leave_name']);                
                $code = strtoupper(substr($explode[0], 0, 1)).''.strtoupper(substr($explode[1], 0, 1));
            }else{;
                $code = $request['edit_leave_name'];
            }
        }else{
            $code = $request['edit_leave_code'];
        }
        $leaveType  = LeaveType::find($request->leave_type_id);
        $leaveType->name = $request['edit_leave_name'];
        $leaveType->code = $code;
        $leaveType->description = $request['edit_leave_description'];
        $leaveType->updated_by = Auth::id();
        $leaveType->save();
        return response()->json(['status' => true,'message' => 'Leave Type Successfully Updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $LeaveType = LeaveType::find($request->id);
        $LeaveType->deleted_by = Auth::id();
        $LeaveType->save();
        $delete = LeaveType::where('id',$request->id)->delete();
        return response()->json(['status' => true,'message' => 'Leave Type successfully deleted!']);
    }

    public function getAllLeaveType(Request $request){
        $data = LeaveType::select('*');

        if($request->filter_search != ""){
            $data->where(function($q) use ($request) {
                $q->orwhere('name','LIKE',"%".$request->filter_search."%");
                $q->orwhere('code','LIKE',"%".$request->filter_search."%");
                $q->orwhere('description','LIKE',"%".$request->filter_search."%");               
            });
        }

        $data->when(!isset($request->order), function ($q) {
            $q->orderBy('id', 'desc');
        });
        return DataTables::of($data)
            ->addIndexColumn() 

            ->addColumn('action', function($row) {
                $btn = "";
                $btn .= '<button type="button" class="btn btn-link hidden-arrow btn-sm px-2 text-body"
                          data-mdb-toggle="dropdown" aria-expanded="false">
                          <mat-icon class="mat-icon material-icons" aria-hidden="true">more_vert</mat-icon>
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item d-flex align-items-center leave_edit" data-mdb-toggle="modal" data-mdb-target="#edit-leave-type" data-id="'.$row->id.'">
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
            ->rawColumns(['action'])
            ->make(true);
    }
}
