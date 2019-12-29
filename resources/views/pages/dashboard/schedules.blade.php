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
					{{-- Alert Message --}}
					@include('pages.includes.flash-message')
					{{-- Create User Form --}}
					<form action="{{ url('create-schedule') }}" method="POST" class="col-md-12">
						@csrf
						<div class="col-md-12 p-0 d-flex mb-5">
							<div class="form-group col-md-4 d-grid">
							    <label for="staff" class="display-7"><i class="fas fa-user-friends"></i> Personel</label>
							    <select class="selectpicker" id="staff" name="staff" data-style="btn-primary" title="Select Staff Personel" data-width="100%" onchange="schedulesFunctions.getStaffSchedule('#staff')" required>
								    @foreach ($staff as $key => $value)
								    	<option data-subtext="{{ $value['permission'] }}" value="{{ $value['user_id'] }}">{{ $value['staff_name'] }}</option>
								    @endforeach
								</select>
							</div>
							{{-- Working Days --}}
							<div class="col-md-2">
								<label for="working-days" class="display-7"><i class="fas fa-calendar-day"></i> Working Days</label>
								<div class="form-group p-0">
									<select id="working-days" class="selectpicker show-tick" multiple data-selected-text-format="count" data-style="btn-primary" title="Working Days" data-width="100%" required disabled>
									    @foreach (Config::get('days') as $key => $value)
									    	<option value="{{ $key }}">{{ $value }}</option>
									    @endforeach
									</select>
								</div>
								<input type="hidden" name="working-days" value="">
							</div>
							<div class="col-md-4">
								<div class="row">
									{{-- Start Time --}}
									<div class="col-md-6 pl-0">
										<div class="form-group">
											<label for="working-days" class="display-7"><i class="fas fa-business-time"></i> Start Time</label>
											<div class="input-group date" id="time-in" name="time-in" data-target-input="nearest">
							                    <input type="text" class="form-control datetimepicker-input" data-target="#time-in" placeholder="Start Time" name="time-in" required disabled/>
							                    <div class="input-group-append" data-target="#time-in" data-toggle="datetimepicker">
							                        <div class="input-group-text bg-primary text-white" disabled><i class="fas fa-clock"></i></div>
							                    </div>
							                </div>
							            </div>
									</div>
									{{-- End Time --}}
									<div class="col-md-6 pr-0">
										<div class="form-group">
											<label for="working-days" class="display-7"><i class="fas fa-user-clock"></i> End Time</label>
											<div class="input-group date" id="time-out" name="time-out" data-target-input="nearest">
							                    <input type="text" class="form-control datetimepicker-input" data-target="#time-out" placeholder="End Time" name="time-out" required disabled/>
							                    <div class="input-group-append" data-target="#time-out" data-toggle="datetimepicker">
							                        <div class="input-group-text bg-primary text-white" disabled><i class="fas fa-clock"></i></div>
							                    </div>
							                </div>
						                </div>
									</div>
								</div>
							</div>
							{{-- Rest Days --}}
							<div class="col-md-2">
								<label for="rest-days" class="display-7"><i class="fas fa-bed"></i> Rest Days</label>
								<div class="form-group p-0">
									<select id="rest-days" name="rest-days" class="selectpicker show-tick" multiple data-selected-text-format="count" data-style="btn-primary" title="Rest Days" data-width="100%" required disabled>
									    @foreach (Config::get('days') as $key => $value)
									    	<option value="{{ $key }}">{{ $value }}</option>
									    @endforeach
									</select>
								</div>
								<input type="hidden" name="rest-days" value="">
							</div>
						</div>
						
						<div class="col-md-12 p-0 mt-5">
							<div class="col-md-12">
								<button id="verify-schedule-btn" type="button" class="btn btn-secondary" onclick="schedulesFunctions.displaySelected();" disabled><i class="fas fa-upload"></i> Plot Schedule to verify</button>
								{{-- LEGEND --}}
								<div class='my-legend float-right v-center'>
									<div class='legend-scale'>
										<ul class='legend-labels font-weight-bold d-flex'>
											<li class="ml-2"><span class="bg-success"></span>Working Days</li>
											<li class="ml-2"><span class="bg-danger"></span>Rest Days</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-12 d-none mt-4" id="time-display-container">
								<label id="time-in-container" class="display-6 font-weight-bold">Time In: <span id="time-in-display"></span></label>
								<label id="time-out-container" class="display-6 font-weight-bold">Time Out:  <span id="time-out-display"></span></label>
							</div>
							{{-- Week Schedule Display --}}
							<div class="col-md-12 v-center text-center">
								<table id="working-days-display" class="table table-bordered float-right mt-3">
									<thead class="text-center">
										@foreach (Config::get('days') as $days =>$value)
									    	<th id="{{ $days }}">{{ $value }}</th>
									    @endforeach
									</thead>
								</table>
							</div>
						</div>
						
						<hr>

						<div class="col-md-4 float-right text-right font-weight-bold">
							<button id="save-schedule" type="submit" class="btn btn-success" disabled="true"><i class="fas fa-save"></i> Save</button>
							<button type="reset" class="btn btn-warning" onclick="schedulesFunctions.resetSelectPicker();"><i class="fas fa-redo"></i> Reset</button>
						</div>
					</form>
				</div>
			</div>
			<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
				<div class="container" id="clinic-schedule-container">
					asdasd
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
		schedulesFunctions.toggleAlert();
	</script>
@endsection