@if ($message = Session::get('success'))
<div class="alert alert-dismissible fade show alert-success" role="alert" data-mdb-color="success">
  <strong>{{ $message }}</strong>
  <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
</div>
@endif 
    
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert" data-mdb-color="danger">
  <strong>{{ $message }}</strong>
  <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
</div>
@endif
     
@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert" data-mdb-color="warning">
  <strong>{{ $message }}</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
     
@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert" data-mdb-color="info">
  <strong>{{ $message }}</strong>
  <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
</div>
@endif
    
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert" data-mdb-color="danger">
  <strong>Please check the form below for errors</strong>
  <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
</div>
@endif
