@if(session()->has('success'))
    <div class="alert alert-success font-weight-bold text-center" role="alert">
		{!! session('success') !!}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
    </div>
@elseif(session()->has('danger'))
    <div class="alert alert-danger font-weight-bold text-center" role="alert">
		{!! session('danger') !!}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
    </div>
@endif