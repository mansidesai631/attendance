@php
$routeName = Route::currentRouteName();
@endphp
<!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse show as-left-nav">
      <div class="position-sticky">
        <a href="{{route('dashboard')}}">
          <div class="site-logo center-block">
            <img alt="" class="site-logo-img img-responsive"
              src="{{asset('img/Manektech_Logo.png')}}">
          </div>
        </a>
        <ul class="list-group list-group-flush sidebar-menus">
          <li>
            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action ripple {{ (in_array(request()->route()->getName(), ['dashboard'])) ? 'active' : '' }}" aria-current="true">
              <i class="ti-home"></i><span>Dashboard</span>
            </a>
          </li>
          <li>
            <a href="{{ route('reports.index') }}" class="list-group-item list-group-item-action ripple {{ (in_array(request()->route()->getName(), ['reports.index'])) ? 'active' : '' }}" aria-current="true">
              <i class="ti-bar-chart"></i><span>Reports</span>
            </a>
          </li>
          <li>
            <a href="{{ route('attendance-entry.index') }}" class="list-group-item list-group-item-action ripple {{ (in_array(request()->route()->getName(), ['attendance-entry.index'])) ? 'active' : '' }}" aria-current="true">
              <i class="ti-notepad"></i><span>Attendance</span>
            </a>
          </li>
          <li>
            <a href="{{ route('field-report.index') }}" class="list-group-item list-group-item-action ripple {{ (in_array(request()->route()->getName(), ['field-report.index'])) ? 'active' : '' }}" aria-current="true">
              <i class="ti-image"></i><span>Field Report</span>
            </a>
          </li>
          <!-- <li>
            <a href="{{ route('attendance-entry.index') }}" class="list-group-item list-group-item-action ripple {{ (in_array(request()->route()->getName(), ['attendance-entry.index'])) ? 'active' : '' }}" aria-current="true">
              <i class="ti-home"></i><span>Field Report</span>
            </a>
          </li> -->
          <li>
            <a href="{{ route('m-challan.index') }}" class="list-group-item list-group-item-action ripple {{ (strpos($routeName, 'm-challan') === 0) ? 'active' : '' }}" aria-current="true">
              <i class="ti-receipt"></i><span>M-Challan </span>
            </a>
          </li>
          <!-- <li>
            <a href="#" class="list-group-item list-group-item-action ripple" aria-current="true">
              <i class="ti-bar-chart"></i><span>Reports </span>
            </a>
          </li> -->
          <li>
            <a href="{{ route('staff-directory.index') }}" class="list-group-item list-group-item-action ripple {{ (strpos($routeName, 'staff-directory') === 0) ? 'active' : '' }}" aria-current="true">
              <i class="ti-user"></i><span>Staff Directory </span>
            </a>
          </li>
          <li>
            <a href="{{ route('leave-management.index') }}" class="list-group-item list-group-item-action ripple {{ (in_array(request()->route()->getName(), ['leave-management.index','leave-type.index','my-history.index','manage-emp-leaves.index'])) ? 'active' : '' }}" aria-current="true">
              <i class="ti-envelope"></i><span>Leave Management </span>
            </a>
          </li>
          <!--<li>
            <a href="#" class="list-group-item list-group-item-action ripple" aria-current="true">
              <i class="ti-calendar"></i><span>Workforce Plan </span>
            </a>
          </li>
          <li>
            <a href="#" class="list-group-item list-group-item-action ripple" aria-current="true">
              <i class="ti-bell"></i><span>Alerts and Approvals </span>
            </a>
          </li> -->
          
          <li>
            <a href="{{ url('settings') }}" class="list-group-item list-group-item-action ripple" aria-current="true">
              <i class="ti-settings"></i><span>Settings </span>
            </a>
          </li>
          
        </ul>
      </div>
      <a class="truein-logo-section" href="javascript:void(0);">
        <img src="{{asset('img/Manektech_Logo.png')}}" alt="logo">
      </a>
    </nav>
    <!-- Sidebar -->