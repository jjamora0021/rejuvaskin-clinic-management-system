@extends('layouts.app')

{{-- Page Style --}}
@section('page-css')

@endsection

{{-- Page Body --}}
@section('content')
 	<div id="dashboard-container">
 		<div class="container text-center" id="logo-container">
            <img src="{{ asset('images/logo-white.png') }}" width="25%">
        </div>
 	</div>
@endsection

{{-- Page JS --}}
@section('page-js')
	<script type="text/javascript" src="{{ asset('js/pages/general-use-js.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			generalFunctions.determinePage('dashboard-dropdown');
		});
	</script>
@endsection