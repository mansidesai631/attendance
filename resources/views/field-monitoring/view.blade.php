@extends('layouts.master')

@section('title','View Field Report')
@section('content')
<!--Main layout-->
  <main class="content-body view-field-report-body">
    <div class="page-body">
      <div class="card mb-3">
        <div class="card-header border-bottom">
          <div class="d-flex">            
            <div class="d-flex flex-column mt-2">
              <h5>View Field Report : {{@$report->title}}</h5>              
            </div>
          </div>
        </div>
        <div class="card-block-hid view-field-report-sec1">
          <div class="card-block px-4 pb-4">
            <div class="page-body">
              <div class="card-body p-9">
                <div class="row">
                  <label class="col-lg-2 mb-6 col-form-label fw-600 pt-0" for="name">Title</label>
                  <div class="col-lg-4 mb-6 fv-row fv-plugins-icon-container">
                    {{@$report->title}}                
                  </div>              
                                  
                  <label class="col-lg-2 mb-6 col-form-label fw-600 pt-0 " for="brand_id">
                    Zone
                  </label>
                  <div class="col-lg-4 mb-6 fv-row fv-plugins-icon-container">
                    {{@$report->site->name}}
                  </div>

                  <label class="col-lg-2 mb-6 col-form-label fw-600 pt-0 " for="brand_id">
                    Circle
                  </label>
                  <div class="col-lg-4 mb-6 fv-row fv-plugins-icon-container">
                    {{@$report->circles->circle_name}}
                  </div> 

                  <label class="col-lg-2 mb-6 col-form-label fw-600 pt-0 " for="brand_id">
                    Distance
                  </label>
                  <div class="col-lg-4 mb-6 fv-row fv-plugins-icon-container">
                    {{@$report->distance}}
                  </div>

                  <label class="col-lg-2 mb-6 col-form-label fw-600 pt-0 " for="brand_id">
                    Officer
                  </label>
                  <div class="col-lg-4 mb-6 fv-row fv-plugins-icon-container">
                    {{@$report->Employee->name}}
                  </div> 

                  <label class="col-lg-2 mb-6 col-form-label fw-600 pt-0 " for="brand_id">
                    Department
                  </label>
                  <div class="col-lg-4 mb-6 fv-row fv-plugins-icon-container">
                    {{@$report->Department->name}}
                  </div> 

                  <label class="col-lg-2 mb-6 col-form-label fw-600 pt-0 " for="brand_id">
                    Date
                  </label>
                  <div class="col-lg-4 mb-6 fv-row fv-plugins-icon-container">
                    {{@$report->created_at}}
                  </div> 

                  <label class="col-lg-2 mb-6 col-form-label fw-600 pt-0 " for="brand_id">
                    Description
                  </label>
                  <div class="col-lg-4 mb-6 fv-row fv-plugins-icon-container">
                    {{@$report->description}}
                  </div>            
                </div>
              </div>               
            </div>
          </div>
        </div>        
      </div>

      @if(count($report->inspection) > 0)
      <div class="card view-field-report-sec1">
        <div class="card-header border-bottom">
          <div class="d-flex">            
            <div class="d-flex flex-column mt-2">
              <h5>View Inspection Details</h5>              
            </div>
          </div>
        </div>
        
        <div class="card-block-hid">
          <div class="card-block px-4 pb-4">
            <div class="page-body">
              @foreach($report->inspection as $i)
                <div class="card-body border-bottom p-9">
                  <div class="row">
                    <label class="col-lg-2 mb-6 col-form-label fw-600 pt-0" for="name">Title</label>
                    <div class="col-lg-10 mb-6 fv-row fv-plugins-icon-container">
                        @if(@$i->title)
                            {{@$i->title}}  
                        @else
                            <div>{{"-"}}</div>
                        @endif              
                    </div>

                    <label class="col-lg-2 mb-6 col-form-label fw-600 pt-0" for="name">Before Note</label>
                    <div class="col-lg-10 mb-6 fv-row fv-plugins-icon-container">
                      {{@$i->before_note}}                
                    </div>              
                                    
                    

                     

                    <label class="col-lg-2 mb-6 col-form-label fw-600 pt-0" for="name">After Note</label>
                    <div class="col-lg-10 mb-6 fv-row fv-plugins-icon-container">
                      {{@$i->after_note}}                
                    </div> 

                    <label class="col-lg-2 mb-6 col-form-label fw-600 pt-0" for="name">Location</label>
                    <div class="col-lg-10 mb-6 fv-row fv-plugins-icon-container">
                        <div class="col-md-1">
                            <?php
                            $lat = '23.022505';
                            $long = '72.5713621';
                            if(@$i->before_lat != "" && @$i->before_long !=""){
                                    $lat = @$i->before_lat;
                                    $long = @$i->before_long;
                            }
                            ?>
                            <a href="https://google.com/maps/?q={{$lat}},{{$long}}" target="_blank"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></a>
                        </div>               
                    </div> 

                    <label class="col-lg-2 mb-6 col-form-label fw-600 pt-0 " for="brand_id">
                      Before Images
                    </label>
                    <div class="col-lg-10 mb-6 fv-row fv-plugins-icon-container">
                      
                        {{-- <a href="javascript:void(0)" data-mdb-toggle="modal" data-mdb-target="#view-gallery" data-id="{{$i->id}}" class="before_image_gallery" data-val="Before">Click Here</a> --}}
                        <div class="row g-3">
                            @if(count($i->beforeImages()->get()) > 0)
                                @foreach($i->beforeImages()->get() as $before_image)
                                <div class="col-md-1">
                                    <a href="{{$before_image->image}}" target="_blank" title="View">
                                    <img src="{{$before_image->image}}" class="rounded-3 img-thumbnail report-thumb" alt="Avatar" />
                                    </a>
                                </div>
                                @endforeach
                            @else
                               <div>{{"-"}}</div>
                            @endif
                        </div>
                    </div>

                    <label class="col-lg-2 mb-6 col-form-label fw-600 pt-0 mt-3" for="brand_id">
                      After Images
                    </label>
                    <div class="col-lg-10 mb-6 fv-row fv-plugins-icon-container mt-3">
                      
                        {{-- <a href="javascript:void(0)" data-mdb-toggle="modal" data-mdb-target="#after-view-gallery" data-id="{{$i->id}}" class="after_image_gallery" data-val="After">Click Here</a> --}}
                        <div class="row mb-4 g-3">
                            @if(count($i->afterImages()->get()) > 0)
                                @foreach($i->afterImages()->get() as $after_images)
                                <div class="col-md-1">
                                    <a href="{{$after_images->image}}" target="_blank" title="View">
                                        <img src="{{$after_images->image}}" class="rounded-3 img-thumbnail report-thumb" alt="Avatar" />
                                    </a>
                                </div>
                                @endforeach
                            @else
                               <div>{{"-"}}</div>
                            @endif
                        </div>
                    </div> 

                    <label class="col-lg-2 mb-6 col-form-label fw-600 pt-0 " for="brand_id">
                      Remark
                    </label>
                    <div class="col-lg-10 mb-6 fv-row fv-plugins-icon-container">
                      <div class="row">
                        <div class="col-12">
                            <div class="comment-wrapchatbox">
                                @if(count($i->inspectionRemarks()->get()) > 0)
                                    <div class="comment-wraprow">
                                        @foreach($i->inspectionRemarks()->get() as $rem)
                                                @if($rem->created_by === Auth::user()->id)
                                                    <div class="comment-chatbox">
                                                        <div class="comment-chatbox-left"></div>
                                                        <div class="comment-chatbox-right">
                                                            <span> {{@$rem->remark}}</span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="comment-chatbox">
                                                        <div class="comment-chatbox-left">
                                                            <span> {{@$rem->remark}}</span>
                                                        </div>
                                                        <div class="comment-chatbox-right"></div>
                                                    </div>
                                                @endif
                                        @endforeach
                                    </div>
                                @endif
                                <div class="comment-input">
                                    <textarea class="form-control" name="remark" id="remark_{{$i->id}}" rows="1"></textarea>
                                    <a href="#" class="form-control remark_sent btn btn-primary" name="remark_submit" value="Send" id="{{$i->id}}">
                                        <i class="fas fa-paper-plane"></i>
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                      </div>
                    </div> 
                     
                  </div>
                </div>              
              @endforeach
            </div>
          </div>
        </div> 
      </div>
      @endif
    </div>
  </main>
  <!--Main layout-->

  <!-- Modal -->
   <div class="modal fade" id="view-gallery" tabindex="-1" aria-labelledby="addusers" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body p-0">
          <button type="button" class="btn-close position-absolute bg-black rounded-0 p-2" data-mdb-dismiss="modal" aria-label="Close" style="position: absolute;z-index: 11;right: 0;"></button>
            <div class="row">
              <div class="col-md-12 mx-auto">
                <div id="carouselExampleInterval" class="carousel slide carousel-fade rounded-3 overflow-hidden" data-mdb-ride="carousel">
                  <div class="carousel-inner" id="view_report_gallery">
                    
                  </div>
                  <button class="carousel-control-prev" data-mdb-target="#carouselExampleInterval" type="button" data-mdb-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" data-mdb-target="#carouselExampleInterval" type="button" data-mdb-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

     <!-- Modal -->
   <div class="modal fade" id="after-view-gallery" tabindex="-1" aria-labelledby="addusers" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body p-0">
          <button type="button" class="btn-close position-absolute bg-black rounded-0 p-2" data-mdb-dismiss="modal" aria-label="Close" style="position: absolute;z-index: 11;right: 0;"></button>
            <div class="row">
              <div class="col-md-12 mx-auto">
                <div id="carouselExampleInterval" class="carousel slide carousel-fade rounded-3 overflow-hidden" data-mdb-ride="carousel">
                  <div class="carousel-inner" id="view_after_gallery">
                    
                  </div>
                  <button class="carousel-control-prev" data-mdb-target="#carouselExampleInterval" type="button" data-mdb-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" data-mdb-target="#carouselExampleInterval" type="button" data-mdb-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
       
@endsection
@push('js')
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','.remark_sent',function(){
        var id = $(this).attr('id');
        var remark = $("#remark_"+id).val();
        $.ajax({
            type: "POST",
            url: "{{route('save.remark')}}",
            data: {
                'id':id,
                'remark':remark,
            },
            success: function (result) {
              if(result.status == true){
                toastr.success(result.message);
                location.reload(true);
              }
            }
        });
    });

    $(document).on('click','.before_image_gallery',function(){
        var id = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url: "{{route('get.before.images')}}",
            data: {
                'id':id,
            },
            success: function (result) {
              if(result.status == true){
                var html = '';
                var after = '';
                $.each(result.data, function( index, value ) {
                  
                    if(index == 0){
                      html += '<div class="carousel-item active" data-mdb-interval="10000"><img src="'+value.image+'" class="d-block mx-auto"/></div>';
                    }else{
                      html += '<div class="carousel-item"><img src="'+value.image+'" class="d-block mx-auto"/></div>';
                    }                  
                });
                $("#view_report_gallery").html(html);
              }
            }
        });
    });

    $(document).on('click','.after_image_gallery',function(){
        var id = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url: "{{route('get.after.images')}}",
            data: {
                'id':id,
            },
            success: function (result) {
              if(result.status == true){
                var html = '';
                var after = '';
                $.each(result.data, function( index, value ) {
                    if(index == 0){
                      after += '<div class="carousel-item active" data-mdb-interval="100"><img src="'+value.image+'" class="d-block mx-auto"/></div>';
                    }else{
                      after += '<div class="carousel-item"><img src="'+value.image+'" class="d-block mx-auto"/></div>';
                    }                  
                });
                $("#view_after_gallery").html(after);
              }
            }
        });
    });
  });
</script>
@endpush('js')