@extends('layouts.app')

@section('content')
	<div class="container-fluid p-3">
      	{{-- View Staff Container --}}
		<div class="col-md-12 mb-3 p-0 d-flex page-header">
			<h3 class="font-weight-bold col-md-10 p-0">View Staff</h3>
		</div>

		<hr>

		<div class="container-fluid" id="view-user-container">
			{{-- Alert Message --}}
			<div class="alert text-center font-weight-bold"></div>
			{{-- Users Table --}}
			<table id="users-table" class="table table-hovered table-striped table-bordered" width="100%">
				<thead class="bg-dark text-white">
					<th hidden>User ID</th>
					<th>Full Name</th>
					<th>Username</th>
					<th>Email</th>
					<th>User Role</th>
					<th class="text-center">Status</th>
					<th class="text-center">Action</th>
				</thead>
				@if(!empty($users))
					<tbody>
						@foreach($users as $key => $value)
							<tr class="font-weight-bold">
								<td hidden>{{ $value['user_id'] }}</td>
								<td>{{ $value['first_name'] }} {{ $value['middle_name'] }} {{ $value['last_name'] }}</td>
								<td>{{ $value['username'] }}</td>
								<td>{{ $value['email'] }}</td>
								<td>{{ $value['permission'] }}</td>
								<td class="text-center font-weight-bold">{{ strtoupper($value['status']) }}</td>
								<td class="text-center">
									<button class="btn btn-sm btn-info" onclick="usersPageFunctions.showUpdateUserModal('{{ $value["user_id"] }}');" {{ $value['disabled'] }}><i class="fas fa-user-edit"></i> Update</button>
									<button class="btn btn-sm btn-danger" onclick="usersPageFunctions.showDeleteUserModal('{{ $value["user_id"] }}');" {{ $value['disabled'] }}><i class="fas fa-user-slash"></i> Delete</button>
								</td>
							</tr>
						@endforeach
					</tbody>
				@else
					<tbody></tbody>
				@endif
			</table>
		</div>          
    </div>
@endsection

@section('page-js')
	<script type="text/javascript" src="{{ asset('js/pages/general-use-js.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/pages/user/user-js.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			generalFunctions.determinePage('staff-dropdown');
		});
	</script>
@endsection