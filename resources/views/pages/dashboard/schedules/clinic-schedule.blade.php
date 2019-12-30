{{-- Create User Form --}}
<form action="{{ url('create-clinic-schedule') }}" method="POST" class="col-md-12">
	@csrf
	<div id="clinic-schedule-container" class="col-md-12 p-0 d-flex mb-5">
		{{-- Working Days --}}
		<div class="col-md-2 offset-md-2">
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

	<div class="col-md-8 offset-md-2" id="holiday-table-container">
		{{-- Alert Message --}}
		<div class="alert font-weight-bold text-center"></div>
		{{-- Holiday Table Container --}}
		<div class="col-md-12 p-0 mb-3 d-flex">
			<div class="col-md-6 p-0 v-center">
				<label for="rest-days" class="display-7 mb-0 font-weight-bold"><i class="fas fa-calendar-day"></i> Holidays&nbsp;&nbsp;<small class="text-danger font-weight-bold">On these days the clinic is closed.</small></label>
			</div>
			<div class="col-md-6 p-0 float-right">
				<button type="button" class="btn btn-sm btn-primary float-right"><i class="far fa-calendar-plus"></i> Add Holiday</button>
			</div>
		</div>
		<table class="table table-hovered table-bordered table-striped" id="holiday-list-table">
			<thead class="bg-dark text-white font-weight-bold">
				<th hidden>Holiday ID</th>
				<th width="40%">Holiday</th>
				<th width="20%" class="text-center">Date</th>
				<th width="40%" class="text-center">Action</th>
			</thead>
			@if(!empty($holidays))
				<tbody>
					@foreach($holidays as $key => $value)
						<tr>
							<td hidden>{{ $value['id'] }}</td>
							<td>{{ $value['holiday'] }}</td>
							<td class="text-center">{{ $value['date'] }}</td>
							<td class="text-center">
								<button type="button" class="btn btn-sm btn-info" onclick="schedulesFunctions.showUpdateHolidayModal('{{ $value["id"] }}');"><i class="fas fa-edit"></i> Update</button>
								<button type="button" class="btn btn-sm btn-danger" onclick="schedulesFunctions.showDeleteHolidayModal('{{ $value["id"] }}');"><i class="fas fa-trash-alt"></i> Delete</button>
							</td>
						</tr>
					@endforeach
				</tbody>
			@else
				<tbody>
					<tr>
						<td colspan="3" class="text-center font-weight-bold">There are no Holidays recorded.</td>
					</tr>
				</tbody>
			@endif
		</table>
	</div>

	<hr>

	<div class="col-md-4 float-right text-right font-weight-bold">
		<button id="save-schedule" type="submit" class="btn btn-success" disabled="true"><i class="fas fa-save"></i> Save</button>
		<button type="reset" class="btn btn-warning" onclick="schedulesFunctions.resetSelectPicker('#clinic-schedule-container');"><i class="fas fa-redo"></i> Reset</button>
	</div>
</form>