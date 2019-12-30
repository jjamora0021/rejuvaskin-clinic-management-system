@extends('layouts.app')

@section('page-css')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/schedule.css') }}">
@endsection

@section('content')
	<div id="schedules-page-container" class="container-fluid p-3">
		{{-- Create User Container --}}
		<div class="col-md-12 mb-3 p-0 d-flex page-header">
			<h3 class="font-weight-bold col-md-10 p-0">Create Schedule</h3>
		</div>

		<hr>

		<nav class="container">
			<div class="nav nav-tabs nav-fill font-weight-bold mt-4" id="nav-tab" role="tablist">
				<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-user-nurse"></i> Staff Schedule</a>
				<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-clinic-medical"></i> Clinic Schedule</a>
			</div>
		</nav>
		<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
			<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-profile-tab">
				<div class="container" id="staff-schedule-container">
					{{-- Staff Schedule --}}
					@include('pages.dashboard.schedules.staff-schedule')
				</div>
			</div>
			<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
				<div class="container" id="clinic-schedule-container">
					{{-- Clinic Schedule --}}
					@include('pages.dashboard.schedules.clinic-schedule')
				</div>
			</div>
		</div>
	</div>
@endsection

@section('page-js')
	<script type="text/javascript" src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/pages/general-use-js.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/pages/schedules/schedules-js.js') }}"></script>
	<script type="text/javascript">
		schedulesFunctions.onLoad();
		// schedulesFunctions.toggleAlert();
	</script>
@endsection