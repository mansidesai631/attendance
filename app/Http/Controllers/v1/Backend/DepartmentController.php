<?php

namespace App\Http\Controllers\v1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use App\Models\Employee;
use DataTables;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $users = Employee::get(['id', 'name']);
        return view('settings.department.index', compact('users'));
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
        $department = new Department();
        $department->name = @$request->department_name;
        $department->site_id = @$request->site_id;
        $department->head_id = @$request->department_head;
        $department->created_by = Auth::id();
        $department->save();
        return response()->json(['status' => true,'message' => 'New Department has been added successfully']);
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
        $getDepartmentData = Department::find($id);
        return response()->json(['status' => true,'data'=>$getDepartmentData]);
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
        $department  = Department::find($request->department_id);
        $department->name = $request['edit_department_name'];
        $department->site_id = $request['site_id'];
        $department->head_id = $request['edit_department_head'];
        $department->updated_by = Auth::id();
        $department->save();
        return response()->json(['status' => true,'message' => 'Department Successfully Updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $department = Department::find($request->id);
        $department->deleted_by = Auth::id();
        $department->save();
        $delete = Department::where('id', $request->id)->delete();
        return response()->json(['status' => true,'message' => 'Department successfully deleted!']);
    }

    public function getAllDepartment(Request $request){
        $user = Employee::find(Auth::id());
         $data = Department::with('employees','createdBy');

        $data->whereHas('createdBy', function($q1) use ($user) {
            $q1->where('site_id',$user->selected_site_id);
        });

        if($request->filter_search != ""){
            $data->where(function($q) use ($request) {
                $q->orwhere('name','LIKE',"%".$request->filter_search."%");
            });
        }

        $data->when(!isset($request->order), function ($q) {
            $q->orderBy('id', 'desc');
        });
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('head', function($row) {
                return @$row->employees->name ?? '';
            })
            ->addColumn('action', function($row) {
                $btn = "";
                $btn .= '<button type="button" class="btn btn-link hidden-arrow btn-sm px-2 text-body"
                          data-mdb-toggle="dropdown" aria-expanded="false">
                          <mat-icon class="mat-icon material-icons" aria-hidden="true">more_vert</mat-icon>
                        </button>
                        <ul class="dropdown-menu shadow-1-strong">
                          <li>
                            <a class="dropdown-item d-flex align-items-center py-3 department_edit" data-mdb-toggle="modal" data-mdb-target="#edit-department" data-id="'.$row->id.'">
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
