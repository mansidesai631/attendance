<div class="row mx-0 mt-2 align-items-start">
  <div class="col-md-3 d-flex justify-content-center pr-0">
    <div>
      <div class="image-container mb-0">
        <div class="mb-1">
          <div class="avatar-container">
            <img class="avatar-content" src="img/default-img.png" width="80" height="80">
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-center px-2 text-break">
        <h6 class="text-center employee-name text-black fs-6"><span id="#employee_name">{{$personalDetails->name}}</h6>
      </div>
    </div>
  </div>
  <div class="col-md-5 d-flex pt-2 pl-0 text-body">
    <div class="w-100">
      <div class="mb-1 d-flex justify-content-between ">
        <div class="col-md-5 p-0 d-flex justify-content-between">
          <div> Mobile No.</div>:
        </div>
        <div class="col-md-7" id="employee_mobile"> {{$personalDetails->mobile}} </div>

      </div>
      <div class="mb-1 d-flex justify-content-between">
        <div class="col-md-5 p-0 d-flex justify-content-between">
          <div> Designation </div>:
        </div>
        <div class="col-md-7 " id="employee_designation"> {{$personalDetails->work->designation->name}} </div>

      </div>
      <div class="mb-1 d-flex justify-content-between">
        <div class="col-md-5 p-0 d-flex justify-content-between">
          <div> Employee ID </div>:
        </div>
        <div class="col-md-7 " id="employee_id"> {{$personalDetails->id}} </div>

      </div>
    </div>
  </div>
</div>