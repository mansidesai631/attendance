<?php
$sites = App\Models\Site::all();
$selected_site = App\Models\Employee::where('id',Auth::id())->first();
?>

<!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-dark as-nav-top fixed-top">
      <!-- Container wrapper -->
      <div class="container-fluid">
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu"
          aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <div class="hamburger-menu-icon"><span></span><span></span><span></span></div>
        </button>

        <!-- Brand -->
        <a class="navbar-brand route-name ms-4" href="#">
          Dashboard
        </a>
        <!-- <a class="navbar-brand text-white" href="#">
          Trial: 10 Days
        </a> -->

        <!-- Right links -->
        <ul class="navbar-nav ms-auto d-flex flex-row align-items-center">
          <!-- Avatar -->
          <li class="nav-item dropdown site-list">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="qa-block" role="button"
              data-mdb-toggle="dropdown" aria-expanded="false">
              {{ @$selected_site->site->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="qa-block">
              <li>
                <div class="mat-search">
                  <input class="mat-input-element" type="text" placeholder="Search Zone" aria-label="dropdown search">
                </div>
              </li>
              @foreach($sites as $s)
              <li><a class="dropdown-item header_site" href="#" data-id="{{ $s->id }}"> {{ $s->name }} </a></li>
              @endforeach
            </ul>
          </li>
          <!-- Notification dropdown -->
          <!-- <li class="support-btn">
            <a class="nav-link me-3 me-lg-0" href="#">
              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">help_outline</mat-icon>
            </a>
          </li>
          <li class="nav-item dropdown header-notification">
            <a class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow" href="#" id="navbarDropdownMenuLink"
              role="button" data-mdb-toggle="dropdown" aria-expanded="false">
              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true">notifications_none</mat-icon>
              <span class="badge rounded-pill badge-notification bg-danger">1</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="#">Some news</a></li>
              <li><a class="dropdown-item" href="#">Another news</a></li>
              <li>
                <a class="dropdown-item" href="#">Something else</a>
              </li>
            </ul>
          </li> -->

          <!-- Avatar -->
          <li class="nav-item dropdown user-profile">
            <span class="vl-user-profile"></span>
            <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#"
              id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
              @if(Auth::user()->image != "")
              <?php
                  $url = URL::to('/').'/storage/profile/'.''.Auth::user()->image
              ?>
              <img src="{{$url}}" class="rounded-circle" height="32" alt="" loading="lazy" />
              @else
                  <img src="https://dashboard.truein.com/staff/assets/staff_imgs/default-img.png" class="rounded-circle" height="32" alt="" loading="lazy" />
              @endif

              {{-- <img src="{{URL::to('/').'/storage/profile/'.''.Auth::user()->image}}" class="rounded-circle" height="32" alt="" loading="lazy" /> --}}
              <div class="user-info">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <span class="user-role">{{ Auth::user()->role->name}} </span>
                </span>
              </div>
              <mat-icon role="img" class="mat-icon material-icons" aria-hidden="true"> keyboard_arrow_down </mat-icon>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="{{ route('profile') }}"><img width="15" src="{{asset('img/icons/avatar.svg')}}"> Profile </a></li>

                <!-- <li><a class="dropdown-item" href="#"><img width="15" src="{{asset('img/icons/notification-settings.svg')}}">
                    Notification preferences</a></li> -->
                <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="ti-layout-sidebar-left me-3"></i> {{ __('Logout') }} </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
          </li>
        </ul>
      </div>
      <!-- Container wrapper -->
    </nav>
<!-- Navbar -->
@stack('css')
@push('js')
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on("click",".header_site",function(){
      var id = $(this).attr('data-id');
      $.ajax({
        type: "GET",
        url: "{{route('change.site')}}",
        data:{
          id : id,
        },
        success: function (result) {
          if(result.status == true){
            console.log(result);
            $("#qa-block").text(result.data);
            window.location.href = "{{route('dashboard')}}";
          }
        }
      });      
    });
  })
</script>
@endpush