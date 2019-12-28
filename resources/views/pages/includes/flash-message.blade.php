@if(session()->has('success'))
    <div class="alert alert-success font-weight-bold text-center" role="alert">
      {!! session('success') !!}
    </div>
@elseif(session()->has('danger'))
    <div class="alert alert-danger font-weight-bold text-center" role="alert">
      {!! session('danger') !!}
    </div>
@endif