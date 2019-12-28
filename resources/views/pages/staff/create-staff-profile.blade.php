@extends('layouts.app')

@section('content')
	<div class="container-fluid p-3">
		{{-- Create User Container --}}
		<div class="col-md-12 mb-3 p-0 d-flex page-header">
			<h3 class="font-weight-bold col-md-10 p-0">Create Staff Profile</h3>
		</div>

		<hr>

		<div class="container-fluid" id="create-user-container">
			{{-- Alert Message --}}
			@include('pages.includes.flash-message')
			{{-- Create User Form --}}
			<form action="{{ url('create-user') }}" method="POST" class="col-md-12">
				@csrf
				<div class="d-flex">
					{{-- Left Content --}}
					<div class="left-content col-md-4">
						{{-- First Name --}}
						<div class="form-group">
							<label for="firstname">First Name</label>
							<input type="text" class="form-control" placeholder="Enter First Name" id="firstname" name="firstname" required>
						</div>
						{{-- Middle Name --}}
						<div class="form-group">
							<label for="middlename">Middle Name</label>
							<input type="text" class="form-control" placeholder="Enter Middle Name" id="middlename" name="middlename">
						</div>
						{{-- Last Name --}}
						<div class="form-group">
							<label for="lastname">Last Name</label>
							<input type="text" class="form-control" placeholder="Enter Last Name" id="lastname" name="lastname" required>
						</div>
					</div>

					{{-- Middle Content --}}
					<div class="middle-content col-md-4">
						{{-- Username --}}
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" placeholder="Enter Username" id="username" name="username" autocomplete="username" required>
						</div>
						{{-- Email --}}
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-control" placeholder="Enter Email Address" id="email" name="email" required>
						</div>
						{{-- User Role --}}
						<div class="form-group">
							<label for="userrole">User Role</label>
							<select class="form-control" id="userrole" name="userrole" required>
							    <option>Select User Role</option>
							    @foreach(Config::get('roles') as $key => $value)
									<option value="{{ $value['role'] }}">{{ $value['permission'] }}</option>
							    @endforeach
							</select>
						</div>
					</div>

					{{-- Right Content --}}
					<div class="right-content col-md-4">
						{{-- Password --}}
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" placeholder="Enter Password" id="password" name="password" autocomplete="new-password" required>
						</div>
						{{-- Confirm Password --}}
						<div class="form-group">
							<label for="confirm-password">Confirm Password</label>
							<input type="password" class="form-control" placeholder="Re-enter Password" id="confirm-password" name="confirm-password" autocomplete="new-password" required>
						</div>
						{{-- Status --}}
						<div class="form-group">
							<label for="status">Status</label>
							<select class="form-control" id="status" name="status" required>
							    <option>Select Employee Status</option>
							    <option value="active">Active</option>
							    <option value="inactive">Inactive</option>
							    <option value="blocked">Blocked</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4 float-right text-right">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Create</button>
					<button type="reset" class="btn btn-sm btn-warning"><i class="fas fa-redo"></i> Reset</button>
				</div>
			</form>
		</div>
	</div>
@endsection

@section('page-js')
	<script type="text/javascript" src="{{ asset('js/pages/general-use-js.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/pages/user/user-js.js') }}"></script>
	<script type="text/javascript">
		generalFunctions.determinePage('staff-dropdown');
	</script>
@endsection