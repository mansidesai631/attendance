<div class="staff-leave-stat">
  <div class="card m-2 p-2" data-mdb-toggle="popover" data-mdb-html="true" data-mdb-placement="top"
    data-mdb-trigger="click"
    data-mdb-content="<div> Alloted: 12  </div> <div> Used: 0 </div> <div> Balance: 12 </div>">
    <div><span class="pb-1 fw-600">Total</span>
      <div class="d-flex"><span>Balance:</span><span id="total_leave">{{$balance}}</span></div>
    </div>
  </div>
  @foreach($leaveType as $type)
  <div class="card m-2 p-2" data-mdb-toggle="popover" data-mdb-html="true" data-mdb-placement="top"
    data-mdb-trigger="click"
    data-mdb-content="<div> Alloted: 12  </div> <div> Used: 0 </div> <div> Balance: 12 </div>">
    <?php
    $alloted = \App\Models\LeaveList::where('employee_id',$id)->where('leave_type_id',$type->id)->where('status','ALLOTED')->sum('tota_days');
    $used = \App\Models\LeaveList::where('employee_id',$id)->where('leave_type_id',$type->id)->where('status','APPROVED')->sum('tota_days');
    $balance  = $alloted - $used;
    ?>
    <div><span class="pb-1 fw-600">{{$type->name}}</span>
      <div class="d-flex"><span>Balance:</span><span>{{$balance}}</span></div>
    </div>
  </div>
  @endforeach
</div>