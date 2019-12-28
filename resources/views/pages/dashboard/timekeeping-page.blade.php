@extends('layouts.app')

@section('page-css')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/calendar.css') }}">
@endsection

@section('content')
	<div id="time-keeping-page-container" class="container-fluid p-3">
      	{{-- View User Container --}}
		<div class="col-md-12 mb-3 p-0 d-flex page-header">
			<h3 class="font-weight-bold col-md-10 p-0">Time Keeping</h3>
		</div>

		<hr>

		<div class="container-fluid">
			<div class="row">
				{{-- TIMEKEEPING --}}
				<div id="time-keeping-records-card" class="card col-md-5">
					{{-- LEGEND --}}
					<div class='my-legend mb-3'>
						<div class='legend-scale'>
							<ul class='legend-labels font-weight-bold d-flex'>
								<li class="ml-2"><span class="bg-primary"></span>Today</li>
								<li class="ml-2"><span class="bg-warning"></span>Holiday</li>
								<li class="ml-2"><span class="bg-danger"></span>Day Off</li>
								{{-- <li><span style='background:#FB8072;'></span>Four</li> --}}
								{{-- <li><span style='background:#80B1D3;'></span>etc</li> --}}
							</ul>
						</div>
					</div>
					{{-- PUNCH IN CLOCK --}}
					<div class="card-header text-center">
						<h3 class="mb-0" id="time-keeping-clock"></h3>
					</div>
					<div class="card-body pl-0 pr-0">
						{{-- CLOCK --}}
						<div class="row mb-5">
							{{-- TIMEKEEPING --}}
							<div class="col-md-6 d-flex">
								<div class="col-md-6">
									<button id="time-in-button" class="btn btn-primary" onclick="timeKeepingFunctions.saveTimeIn();">TIME IN</button>
								</div>
								<div class="col-md-6">
									<button id="time-out-button" class="btn btn-primary" onclick="timeKeepingFunctions.saveTimeOut();">TIME OUT</button>
								</div>
							</div>
							{{-- OTHERS --}}
							<div class="col-md-6 text-right d-flex">
								<div class="col-md-6">
									<button id="time-keeping-complaint-button" class="btn btn-success" onclick="timeKeepingFunctions.timeKeepingComplaint();">Complaints</button>
								</div>
								<div class="col-md-6">
									<button id="file-leaves-button" class="btn btn-success" onclick="timeKeepingFunctions.fileLeaves();">Leaves</button>
								</div>
							</div>
						</div>
						{{-- RECORDS --}}
						<h5 class="font-weight-bold">Time Keeping Records</h5>
						<div class="alert text-center font-weight-bold d-none"></div>
						<div id="time-keeping-records-container">
							<table id="time-keeping-records-table" class="table table-hovered table-striped table-bordered" width="100%">
								<thead>
									<th class="text-center font-weight-bold bg-dark text-white" width="15%">{{ $month_now }} {{ $year_now }}</th>
									<th class="text-center font-weight-bold bg-dark text-white" width="25%">Time In</th>
									<th class="text-center font-weight-bold bg-dark text-white" width="25%">Time Out</th>
									<th class="text-center font-weight-bold bg-dark text-white" width="12.5%">Reg Hrs</th>
									<th class="text-center font-weight-bold bg-dark text-white" width="12.5%">OT Hrs</th>
								</thead>
								<tbody class="text-center">
									@for ($i = 1; $i <= $number_of_days; $i++)
										<tr id="{{ $i }}" class="{{ $i == $day_now ? "text-white bg-primary font-weight-bold" : "" }}">
											<td>{{ $i }}</td>
											@if(isset($records[$i]))
												<td class="time-in">{{ $records[$i]['time_in'] }}</td>
												<td class="time-out">{{ $records[$i]['time_out'] }}</td>
												<td class="reg-hours">{{ (float)$records[$i]['total_hours_regular'] }}</td>
												<td class="ot-hours">{{ (float)$records[$i]['total_hours_overtime'] }}</td>
											@else
												<td class="time-in"></td>
												<td class="time-out"></td>
												<td class="reg-hours"></td>
												<td class="ot-hours"></td>
											@endif
										<tr>
									@endfor
								</tbody>
							</table>
						</div>
					</div>
				</div>

				{{-- CALENDAR --}}
				<div id="calendar-container" class="col-md-7">
					<div id="calendar"></div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('page-js')
	<script type="text/javascript" src="{{ asset('js/calendar.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/pages/general-use-js.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/pages/timekeeping/timekeeping-js.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			timeKeepingFunctions.onLoad();
			timeKeepingFunctions.scrollToDate('{{ $day_now }}')
		});
	</script>
@endsection