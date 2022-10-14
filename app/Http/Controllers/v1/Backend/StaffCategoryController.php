<?php

namespace App\Http\Controllers\v1\Backend;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StaffCategory;
use DataTables;

class StaffCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('settings.staff-category.index');
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
        $staffCategory = new StaffCategory();
        $staffCategory->name = @$request->staff_category_name;
        $staffCategory->ad_limit = @$request->staff_category_ad_limit;
        $staffCategory->created_by = Auth::id();
        $staffCategory->save();
        return response()->json(['status' => true,'message' => 'New staff category has been added successfully']);
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
        $getStaffCategoryData = StaffCategory::find($id);
        return response()->json(['status' => true,'data'=>$getStaffCategoryData]);
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
        $department  = StaffCategory::find($request->staff_category_id);
        $department->name = $request['edit_staff_category_name'];
        $department->ad_limit = $request['edit_staff_category_ad_limit'];
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
        $staffCategory = StaffCategory::find($request->id);
        $staffCategory->deleted_by = Auth::id();
        $staffCategory->save();
        $delete = StaffCategory::where('id', $request->id)->delete();
        return response()->json(['status' => true,'message' => 'Staff category successfully deleted!']);
    }

    public function getAllStaffCategory(Request $request){
        $data = StaffCategory::select('*');

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

            ->addColumn('action', function($row) {
                $btn = "";
                $btn .= '<button type="button" class="btn btn-link hidden-arrow btn-sm px-2 text-body"
                          data-mdb-toggle="dropdown" aria-expanded="false">
                          <mat-icon class="mat-icon material-icons" aria-hidden="true">more_vert</mat-icon>
                        </button>
                        <ul class="dropdown-menu shadow-1-strong">
                          <li>
                            <a class="dropdown-item d-flex align-items-center py-3 staff_category_edit" data-mdb-toggle="modal" data-mdb-target="#edit-category" data-id="'.$row->id.'">
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

    public function updateStaffType(Request $request)
    {
        $site  = Site::find($request->site_id);
        $site->employee_mode = $request['staff_type'];
        $site->updated_by = Auth::id();
        $site->save();
        return response()->json(['status' => true,'message' => 'Staff Type Successfully Updated!']);
    }

    public function resetStaffType(Request $request)
    {
        $site  = Site::find($request->site_id);
        $data['mode'] = $site->employee_mode;
        
        return response()->json(['status' => true,'message' => 'Staff Type Successfully Updated!', 'data' => $data]);
    }
}
