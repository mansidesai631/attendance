<?php

namespace App\Http\Controllers\v1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Employee;
use DataTables;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('leave-management.shift.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start_time = ($request->start_time) ? date('H:i:s',strtotime($request->start_time)) : NULL;
        $end_time = ($request->end_time) ? date('H:i:s',strtotime($request->end_time)) : NULL;

        $shift = new Shift();
        $shift->site_id = @$request->site_id;
        $shift->name = @$request->name;
        $shift->code = @$request->code;
        $shift->grace_time = @$request->grace_time;
        $shift->start_time = $start_time;
        $shift->end_time = $end_time;
        $shift->created_by = Auth::id();


        $shift->save();
        return response()->json(['status' => true,'message' => 'New Shift has been added successfully']);
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
        $getShiftData = Shift::find($id);
        $in = date('h:i A',strtotime($getShiftData->start_time));
        $out = date('h:i A',strtotime($getShiftData->end_time));
        return response()->json(['status' => true,'in'=>$in,'out'=>$out,'data'=>$getShiftData]);
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
        $start_time = ($request->edit_start_time) ? date('H:i:s',strtotime($request->edit_start_time)) : NULL;
        $end_time = ($request->edit_end_time) ? date('H:i:s',strtotime($request->edit_end_time)) : NULL;

        $shift  = Shift::find($request->shift_id);

        $shift->site_id = @$request->site_id;
        $shift->name = @$request->edit_name;
        $shift->code = @$request->edit_code;
        $shift->grace_time = @$request->edit_grace_time;
        $shift->start_time = $start_time;
        $shift->end_time = $end_time;
        $shift->updated_by = Auth::id();
        $shift->save();
        return response()->json(['status' => true,'message' => 'Shift Successfully Updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $shift = Shift::find($request->id);
        $shift->deleted_by = Auth::id();
        $shift->save();
        $delete = Shift::where('id', $request->id)->delete();
        return response()->json(['status' => true,'message' => 'Shift successfully deleted!']);
    }

    public function getAllShift(Request $request){
        $user = Employee::find(Auth::id());
        $data = Shift::select('*');

        $data->whereHas('createdBy', function($q1) use ($user) {
            $q1->where('site_id',$user->selected_site_id);
        });

        if($request->filter_search != ""){
            $data->where(function($q) use ($request) {
                $q->orwhere('name','LIKE',"%".$request->filter_search."%");
                $q->orwhere('code','LIKE',"%".$request->filter_search."%");
                $q->orwhere('start_time','LIKE',"%".date('H:i:s',strtotime($request->filter_search))."%");
                $q->orwhere('end_time','LIKE',"%".date('H:i:s',strtotime($request->filter_search))."%");
                $q->orwhere('grace_time','LIKE',"%".$request->filter_search."%");
            });
        }

        $data->when(!isset($request->order), function ($q) {
            $q->orderBy('id', 'desc');
        });
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('start_time', function($row) { 
                return date('g:i A',strtotime($row->start_time));
            })
            ->addColumn('end_time', function($row) { 
                return date('g:i A',strtotime($row->end_time));
            })
            ->addColumn('action', function($row) {
                $btn = "";
                $btn .= '<button type="button" class="btn btn-link hidden-arrow btn-sm px-2 text-body"
                          data-mdb-toggle="dropdown" aria-expanded="false">
                          <mat-icon class="mat-icon material-icons" aria-hidden="true">more_vert</mat-icon>
                        </button>
                        <ul class="dropdown-menu shadow-1-strong">
                          <li>
                            <a class="dropdown-item d-flex align-items-center py-3 shift_edit" data-mdb-toggle="modal" data-mdb-target="#edit-shift-modal" data-id="'.$row->id.'">
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
