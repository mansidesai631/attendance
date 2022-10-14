<?php

namespace App\Http\Controllers\v1\Backend;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Site;
use DataTables;
use Illuminate\Database\Eloquent\Builder;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('settings.sites.index');
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
        $site = new Site();
        $site->name = $request['site_name'];
        $site->addess = $request['site_address'];
        $site->timezone = $request['timezone'];
        $site->code = $request['countries'];
        $site->ad_limit = $request['attendance_limit'];
        if($request->site_logo_file != ""){
            $filepath  = $request->site_logo_file;
            $filepathName = 'SiteLogo-'.time().'.'. $filepath->getClientOriginalExtension();
            $filepath->move(storage_path('app/public/siteLogo/'), $filepathName); 
            $site->logo = $filepathName;
        }
        $site->created_by = Auth::id();
        $site->save();
        return response()->json(['status' => true,'message' => 'New Site has been added successfully']);
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
        $getSiteData = Site::find($id);
        return response()->json(['status' => true,'data'=>$getSiteData]);
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
        $site  = Site::find($request->edit_site_id);
        $site->name = $request['edit_site_name'];
        $site->addess = $request['edit_site_address'];
        $site->timezone = $request['edit_timezone'];
        $site->code = $request['edit_countries'];
        $site->ad_limit = $request['edit_attendance_limit'];
        if($request->edit_site_logo_file != ""){
            if($site->logo != ""){
                $url = storage_path('app/public/siteLogo/').''.$site->logo;
                if(file_exists($url)){
                    unlink($url);
                }                    
            }                

            $filepath  = $request->edit_site_logo_file;
            $filepathName = 'SiteLogo-'.time().'.'. $filepath->getClientOriginalExtension();
            $filepath->move(storage_path('app/public/siteLogo/'), $filepathName); 
            $site->logo = $filepathName;
        }

        $site->updated_by = Auth::id();
        $site->save();
        return response()->json(['status' => true,'message' => 'Site Successfully Updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $site = Site::find($request->id);
        $site->deleted_by = Auth::id();
        $site->save();
        $delete = Site::where('id', $request->id)->delete();
        return response()->json(['status' => true,'message' => 'Site successfully deleted!']);
    }

    public function getAllSite(Request $request){
        $data = Site::with('employees');

        if($request->filter_search != ""){
            $data->where(function($q) use ($request) {
                $q->orwhere('name','LIKE',"%".$request->filter_search."%");    
                $q->orwhere('addess','LIKE',"%".$request->filter_search."%");
                $q->orwhere('code','LIKE',"%".$request->filter_search."%");   
                $q->orwhere('timezone','LIKE',"%".$request->filter_search."%");   
            });
        }

        $data->when(!isset($request->order), function ($q) {
            $q->orderBy('id', 'desc');
        });
        return DataTables::of($data)
            ->addIndexColumn() 
            ->addColumn('current_active_users', function($row) {  
                return @$row->activeUser->count() ?? ''; 
            })
            ->addColumn('action', function($row) {
                $btn = "";
                $btn .= '<button type="button" class="btn btn-link hidden-arrow btn-sm px-2 text-body"
                          data-mdb-toggle="dropdown" aria-expanded="false">
                          <mat-icon class="mat-icon material-icons" aria-hidden="true">more_vert</mat-icon>
                        </button>
                        <ul class="dropdown-menu shadow-1-strong">
                          <li>
                            <a class="dropdown-item d-flex align-items-center py-3 edit_site" data-mdb-toggle="modal" data-mdb-target="#edit-site" data-id="'.$row->id.'">
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

    public function getStaff(){
        $staff = Employee::all();
        return response()->json(['status' => true,'data' => $staff]);
    }

    public function saveDefaultManager(Request $request){
        $employee = Employee::find($request->id);
        $site = Site::where('id',$employee->selected_site_id)->update(['default_manager_id'=>$request->id]);
        return response()->json(['status' => true,'message' => 'Success!']);
    }
}
