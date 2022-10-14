@if(count($leaveDetails) > 0)
<table class="employee-leave table table-bordered border-bottom">
  <thead>
    <tr>
      <th class="th-sm">Name</th>
      <th class="th-sm">Leave Type</th>
      <th class="th-sm">Start Date</th>
      <th class="th-sm">End Date</th>
      <th class="th-sm">Total Days</th>
      <th class="th-sm">Document</th>
      <th class="th-sm">Reason</th>
      <th class="th-sm">Approver</th>
      <th class="th-sm">Admin/Manager Comment</th>
      <th class="th-sm">Last Update Date</th>
      <th width="80" class="th-sm">Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach($leaveDetails as $leave)
    <tr>
      <td>{{$leave->employee->name}}</td>
      <td><a href="javascript:" data-mdb-toggle="popover" data-mdb-html="true" data-mdb-placement="top" class="text-body fw-600"
          data-mdb-trigger="click" data-mdb-content="<div class='d-flex justify-content-start pb-3'><b>Leave Details</b></div>
          <div class='d-table'>
            <div class='d-table-row table-row'>
              <div class='d-table-cell key'><b>Applied by</b></div>
              <div class='d-table-cell value'>Naushil Jain <span style='font-size: 12px;'>(1)</span></div>
            </div>
            <div class='d-table-row table-row'>
              <div class='d-table-cell key'>
                <b>Leave Allotted</b>
              </div>
              <div class='d-table-cell value'>Privilege Leave</div>
            </div>
            <div class='d-table-row table-row'>
              <div class='d-table-cell key'><b>Leave Date</b></div>
              <div class='d-table-cell value'>-
                <span>- -</span>
              </div>
            </div>
            <div class='d-table-row table-row'>
              <div class='d-table-cell key'><b>No. of days</b></div>
              <div class='d-table-cell value'>0.00</div>
            </div>
            <div class='d-table-row table-row'>
              <div class='d-table-cell key'><b>Applied On</b></div>
              <div class='d-table-cell value'>31-May-2022 11:32</div>
            </div>
          </div>
          <span class='status-tag'>Pending</span>
          <div class='mt-2 leave-history-content '>
            <div class='mt-2 '>
              <div class='d-flex justify-content-center'><b class='approvals-title '>Approval</b>
                <br>
              </div>
              <div class='d-table'>
                <div class='d-table-row'><b> Pending </b></div>
                <div class='d-table-row table-row'>
                  <div class='d-table-cell key'><b>Approver</b></div>
                  <div class='d-table-cell value'>Any Admin</div>
                </div>
                <div class='d-table-row table-row'>
                  <div class='d-table-cell key'><b>Approved by</b></div>
                  <div class='d-table-cell value'>Naushil Jain</div>
                </div>
                <div class='d-table-row table-row'>
                  <div class='d-table-cell key'><b>Status</b></div>
                  <div class='d-table-cell value'>Pending <span class='ml-2'></span></div>
                </div>
              </div>
            </div>
          </div>">
          {{$leave->LeaveType->name}}</a>
      </td>
      <td>{{($leave->status == 'ALLOTED')?'-':date('m/d/Y',strtotime($leave->start_date))}}</td>
      <td>{{($leave->status == 'ALLOTED')?'-':date('m/d/Y',strtotime($leave->end_date))}}</td>
      <td>{{$leave->tota_days}}</td>
      <td></td>
      <td>{{$leave->leave_applied_reason}}</td>
      <td></td>
      <td>Any Admin</td>
      <td>{{date('d-M-Y H:i',strtotime($leave->updated_at))}}</td>
      <td>{{$leave->status}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endif