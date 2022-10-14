<?php

namespace App\Http\Controllers\v1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\MChallan;
use App\Models\MChallanImage;
use DataTables;
use App\Models\Employee;
use App\Models\Department;
use URL;
use App\Models\Site;
use App\Helpers\Helper;

class MChallanController extends Controller
{
	public function index(){
        $staff = Employee::all();
        $department = Department::all();
        $sites = Site::all();
		return view('m-challan.index',compact('staff','department','sites'));
	}

    public function getAllChannel(Request $request){
        $data = MChallan::with('employee','employee.work.department','mChallanImages','site','wards','circles');

        if($request->filter_search != ""){
            $data->where(function($q) use ($request) {
                $q->orwhere('name_of_citizen','LIKE',"%".$request->filter_search."%");
                $q->orwhere('mobile','LIKE',"%".$request->filter_search."%");
                $q->orwhere('id_type','LIKE',"%".$request->filter_search."%");
                $q->orwhere('id_number','LIKE',"%".$request->filter_search."%");
                $q->orwhere('amount_of_fine','LIKE',"%".$request->filter_search."%");

                $q->orwhereHas('employee', function($q2) use ($request) {
                    $q2->where('name','LIKE',"%".$request->filter_search."%");
                });

                $q->orwhereHas('employee.work.department', function($q3) use ($request) {
                    $q3->where('name','LIKE',"%".$request->filter_search."%");
                });

                $q->orwhereHas('site', function($q3) use ($request) {
                    $q3->where('name','LIKE',"%".$request->filter_search."%");
                });

                $q->orwhereHas('wards', function($q3) use ($request) {
                    $q3->where('ward_name','LIKE',"%".$request->filter_search."%");
                });

                $q->orwhereHas('circles', function($q3) use ($request) {
                    $q3->where('circle_name','LIKE',"%".$request->filter_search."%");
                });
            });
        }

        if($request->filter_officer != ""){
            $data->where(function($q1) use ($request) {
                $q1->whereHas('employee', function($q2) use ($request) {
                    $q2->where('id',$request->filter_officer);
                });
            });
        }

        if($request->filter_zone != ""){
            $data->where(function($q1) use ($request) {
                $q1->whereHas('site', function($q2) use ($request) {
                    $q2->where('id',$request->filter_zone);
                });
            });
        }

        if($request->filter_department != ""){
            $data->where(function($q1) use ($request) {
                $q1->whereHas('employee.work.department', function($q2) use ($request) {
                    $q2->where('id',$request->filter_department);
                });
            });
        }

        $data->when(!isset($request->order), function ($q) {
            $q->orderBy('id', 'desc');
        });
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('concern_officer',function($row){
                return @$row->employee->name;
            })
            ->addColumn('department',function($row){
                return @$row->employee->work->department->name;
            })
            ->addColumn('amount_of_fine',function($row){
                return number_format(@$row->amount_of_fine,2);
            })
            ->addColumn('address',function($row){
                return @$row->address;
            })
            ->addColumn('created_at',function($row){
                return @$row->created_at;
            })
            ->addColumn('reason',function($row){
                return @$row->reason ?? '-';
            })
            ->addColumn('zone',function($row){
                return @$row->site->name;
            })
            ->addColumn('ward',function($row){
                return @$row->wards->ward_name;
            })
            ->addColumn('circle',function($row){
                return @$row->circles->circle_name;
            })
            ->addColumn('action', function($row) {
                $class ='disabled';
                $disabled = 'disabled';
                $href = '';
                foreach($row->mChallanImages as $video){
                    if($video->type == 'video'){
                        $class = '';
                        $href = $video->image;
                    }
                    if($video->type == 'image'){
                        $disabled = '';
                    }
                }
                $btn = "";
                $btn .= '<div class="d-flex"><a class="dropdown-item d-flex align-items-center leave_edit '.$disabled.'" data-id="'.$row->id.'" data-mdb-toggle="modal" data-mdb-target="#view-gallery" id="view_report_images">
                              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">image</mat-icon>
                            </a>
                            <a class="dropdown-item d-flex align-items-center leave_edit '.$class.'" href="'.$href.'" target="_blank">
                              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">videocam</mat-icon>
                            </a>
                            <a class="dropdown-item d-flex align-items-center href="" href="'.route('view.map',$row->id).'" target="_blank">
                              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">map</mat-icon>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="'.route('m-challan.show',($row->id)).'" target="_blank">
                              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">remove_red_eye</mat-icon>
                            </a></div>';
                return $btn;
            })

            ->orderColumn('id', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->rawColumns(['concern_officer','department','action'])
            ->make(true);
    }

    public function getImages(Request $request){
        $id = $request->id;
        $image = MChallanImage::where('m_challan_id',$id)->where('type','image')->get();
        return response()->json(['status' => true,'data' => $image]);
    }

    public function show($id)
    {
        $challan = MChallan::with('employee.work.department','employee','site','wards','employee.work.designation')->where('id',$id)->first();
        $fine_in_words = ucfirst(Helper::getIndianCurrency($challan->amount_of_fine));
        return view('m-challan.view',compact('challan','fine_in_words'));
    }

    public function viewMap($id){
        $lat = '23.022505';
        $long = '72.5713621';
        $challan = MChallan::find($id);
        if($challan->latitude != "" && $challan->longitude !=""){
            $lat = $challan->latitude;
            $long = $challan->longitude;
        }
        
       return view('m-challan.map',compact('lat','long'));
    }
}
