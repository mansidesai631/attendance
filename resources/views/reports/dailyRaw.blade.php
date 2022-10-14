<table class="department table table-bordered border-bottom">
  <thead>
    <tr>
      <th class="th-sm th-name">Name</th>
      <th class="th-sm">Email</th>
      <th class="th-sm">Employee Id</th>
      <th width="80" class="th-sm">Zone</th>
      <th width="80" class="th-sm">Ward</th>
      <th width="80" class="th-sm">Department</th>
      <th width="80" class="th-sm">Designation</th>
      <th width="80" class="th-sm">Manager  </th>
      <th width="80" class="th-sm">In-Time </th>
      <th width="80" class="th-sm">In-Map Url </th>
      <th width="80" class="th-sm">Out-Time</th>
      <th width="80" class="th-sm">Out-Map Url </th>
      <th width="80" class="th-sm">Time Spent</th>
      <th width="80" class="th-sm">Status</th>
    </tr>
  </thead>
  <tbody>
    @forelse($employee as $single_employee)
    <tr>
      <td>
        <div class="name-row">
            @if($single_employee['image'])
            <div class="staff-img">
              <img src="{{$single_employee['profile_path']}}" alt="img"></span>
            </div>
            @else
              <div class="cricle-img position-relative">
                  <div class="avatar-container">
                      <div class="avatar-content" style="background-color: #322a24;">{{ucwords($single_employee['name'][0].$single_employee['name'][1])}}</div>
                  </div>
              </div>
            @endif
            <div class="name-text">
                <div class="d-flex w-100">
                    <div>
                      <div>
                          <span>{{$single_employee['name']}} </span>
                      </div>
                    </div>
                </div>
            </div>
        </div>
      </td>
      <td> {{$single_employee['email']}} </td>
      <td>{{$single_employee['work']['employee_id']}}</td>
      <td>{{$single_employee['work']['site'] ? $single_employee['work']['site']['name'] : '-'}}</td>
      <td>{{$single_employee['work']['ward'] ? $single_employee['work']['ward']['ward_name'] : '-'}}</td>
      <td>{{$single_employee['work']['department'] ? $single_employee['work']['department']['name'] : '-'}}</td>
      <td>{{$single_employee['work']['designation'] ? $single_employee['work']['designation']['name'] : '-'}}</td>
      <td>{{$single_employee['work']['managers'] ? $single_employee['work']['managers']['name'] : '-'}}</td>
      <td>{{$single_employee['attendanceSingle'] ? $single_employee['attendanceSingle']['in_time'] : '-'}}</td>
      <td style="text-align: center;font-size: 20px;"> <a href="https://google.com/maps/?q=23.014509,72.591759" target="_blank"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></a></td>
      <td>{{$single_employee['attendanceSingle'] ? $single_employee['attendanceSingle']['out_time'] : '-'}}</td>
      <td style="text-align: center;font-size: 20px;"> <a href="https://google.com/maps/?q=23.014509,72.591759" target="_blank"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></a></td>
      <td>{{$single_employee['attendanceSingle'] ? $single_employee['attendanceSingle']['time_spent'] : '-'}}</td>
      <td>{{$single_employee['attendanceSingle'] ? 'In' : 'Not-In'}}</td>
    </tr>
    @empty
    <tr><td colspan="12"><b>No record found..!</b></td></tr>
    @endforelse
  </tbody>
</table>
{{ $employee->links('pagination::bootstrap-5') }}
