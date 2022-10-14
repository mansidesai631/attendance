<table class="department individule-department table table-bordered border-bottom">
  <thead>
    <tr>
      <th class="th-sm th-name">Day</th>
      <th class="th-sm">Date</th>
      <th width="80" class="th-sm">Photo</th>
      <th width="80" class="th-sm"> In-Time </th>
      <th width="80" class="th-sm"> Out-Time </th>
      <th width="80" class="th-sm"> Time spent </th>
      <th width="80" class="th-sm"> In Geofencing </th>
      <th width="80" class="th-sm"> Out Geofencing </th>
      <th width="80" class="th-sm"> Status </th>
    </tr>
  </thead>
  <tbody>
    @forelse($attendances as $att)
      <tr>
        <td>
          {{date('l', strtotime($att['created_at']))}}
        </td>
        <td>{{date('F-d-Y', strtotime($att['created_at']))}}</td>
        <td>
          <span class="staff-img staff-namenumber">A</span>
        </td>
        <td>{{$att['in_time']}}</td>
        <td>{{$att['out_time']}}</td>
        <td>{{$att['time_spent']}}</td>
        <td>-</td>
        <td>-</td>
        <td>{{$att['in_time'] ? 'PR' : 'AB'}}</td>
      </tr>
    @empty
    <tr><td colspan="12"><b>No record found..!</b></td></tr>

    @endforelse

  </tbody>
</table>
{{ $attendances->links('pagination::bootstrap-5') }}
