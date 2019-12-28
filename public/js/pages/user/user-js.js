/**
 * [usersPageFunctions description]
 * @type {Object}
 */
usersPageFunctions = {
	/**
	 * [repopulateUserTable description]
	 * @return {[type]} [description]
	 */
	repopulateUserTable: function()
	{
		$.ajax({
			url: window.location.origin + '/get-users',
		})
		.done(function(response) {
			$('#users-table tbody').empty();
			$.each(response, function(index, el) {
				var show_update_modal = "usersPageFunctions.showUpdateUserModal('"+el["user_id"]+"');"
				var show_delete_modal = "usersPageFunctions.showDeleteUserModal('"+el["user_id"]+"');"
				var rows = '<tr class="font-weight-bold">\
								<td hidden>'+el["user_id"]+'</td>\
								<td>'+el["first_name"]+' '+el["middle_name"]+' '+el["last_name"]+'</td>\
								<td>'+el["username"]+'</td>\
								<td>'+el["email"]+'</td>\
								<td>'+el["permission"]+'</td>\
								<td class="text-center font-weight-bold">'+el["status"].toUpperCase()+'</td>\
								<td class="text-center">\
									<button class="btn btn-sm btn-info" onclick="'+show_update_modal+'"><i class="fas fa-user-edit"></i> Update</button>\
									<button class="btn btn-sm btn-danger" onclick="'+show_delete_modal+'"><i class="fas fa-user-slash"></i> Delete</button>\
								</td>\
							</tr>';
				$('#users-table tbody').append(rows);
			});
		});
	},

	/**
	 * [showUpdateUserModal description]
	 * @param  {[type]} user_id [description]
	 * @return {[type]}         [description]
	 */
	showUpdateUserModal: function(user_id)
	{
		$('.modal').modal({
			backdrop: 'static',
			keyboard: false
		});

		$('.modal .modal-header').addClass('bg-dark text-white');
		$('.modal .modal-title').empty().append('Update User');
		$('.modal .modal-body').empty();

		var content = '';

		$.ajax({
			url: window.location.origin + '/get-user-details',
			data: { 'user_id' : user_id },
		})
		.done(function(response) {
			content = '<div class="d-flex">\
							<div class="left-content col-md-6">\
								<div class="form-group">\
									<label for="first_name">First Name</label>\
									<input type="text" class="form-control" placeholder="Enter First Name" id="first_name" name="first_name" value="'+response['user_details']['first_name']+'">\
								</div>\
								<div class="form-group">\
									<label for="middle_name">Middle Name</label>\
									<input type="text" class="form-control" placeholder="Enter Middle Name" id="middle_name" name="middle_name" value="'+response['user_details']['middle_name']+'">\
								</div>\
								<div class="form-group">\
									<label for="last_name">Last Name</label>\
									<input type="text" class="form-control" placeholder="Enter Last Name" id="last_name" name="last_name" value="'+response['user_details']['last_name']+'">\
								</div>\
								<div class="form-group">\
									<label for="username">Username</label>\
									<input type="text" class="form-control" placeholder="Enter Username" id="username" name="username" autocomplete="username" value="'+response['user_details']['username']+'">\
								</div>\
							</div>\
							<div class="right-content col-md-6">\
								<div class="form-group">\
									<label for="email">Email</label>\
									<input type="email" class="form-control" placeholder="Enter Email Address" id="email" name="email" value="'+response['user_details']['email']+'">\
								</div>\
								<div class="form-group">\
									<label for="user_role">User Role</label>\
									<select class="form-control" id="user_role" name="user_role">\
									</select>\
								</div>\
								<div class="form-group">\
									<label for="password">Change Password?<span class="text-danger"> Leave if want to retain password</span></label>\
									<input type="password" class="form-control" placeholder="Enter Password" id="password" name="password" autocomplete="new-password" value="">\
								</div>\
								<div class="form-group">\
									<label for="status">Status</label>\
									<select class="form-control" id="status" name="status">\
									    <option>Select Employee Status</option>\
									    <option value="active">Active</option>\
									    <option value="inactive">Inactive</option>\
									    <option value="blocked">Blocked</option>\
									</select>\
								</div>\
							</div>\
						</div>';

			$('.modal .modal-body').append(content);

			var options = '';
			options += '<option>Select User Role</option>';
			console.log(response['roles']);
			$.each(response['roles'], function(index, value) {
				if(response['user_details']['user_role'] == value['role']) {
					options += '<option selected="selected" value="'+value["role"]+'">'+value["permission"]+'</option>';
				}
				else {
					options += '<option value="'+value["role"]+'">'+value["permission"]+'</option>';
				}
			});
			$('#user_role').append(options);

			$('#status option[value="'+response['user_details']['status']+'"]').attr('selected',true);
		});

		var update_user = "usersPageFunctions.updateUser('"+user_id+"')";
		var button_container = '<button type="button" class="btn btn-sm btn-success" data-dismiss="modal" onclick="'+update_user+'"><i class="fas fa-user-edit"></i> Update User</button>\
								<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>';
		$('.modal .modal-footer').empty().append(button_container);
	},

	/**
	 * [updateUser description]
	 * @param  {[type]} user_id [description]
	 * @return {[type]}         [description]
	 */
	updateUser: function(user_id)
	{
		var input_obj = {};
		$.each($('.modal input'), function(index, el) {
			input_obj[el.getAttribute('id')] = el.value;
		});
		
		$.each($('.modal select option:selected'), function(index, el) {
			input_obj[el.parentNode.getAttribute('id')] = el.value;
		});

		if(input_obj.password == '') {
			delete input_obj.password;
		}

		$.ajax({
			url: window.location.origin + '/update-user',
			data: { 
				'user_id' : user_id,
				'data' : input_obj
			},
		})
		.done(function(response) {
			if(response == true) {
				$('.alert').addClass('alert-success').empty().append('Staff Successfully Updated.');
				usersPageFunctions.repopulateUserTable();
			}
			else {
				$('.alert').addClass('alert-danger').empty().append('Staff Failed to be Updated.');	
			}
			setTimeout(function() { 
				$('.alert').empty().removeClass('alert-danger alert-success').toggleClass('hidden');
			}, 5000);
		});
	},

	/**
	 * [showDeleteUserModal description]
	 * @param  {[type]} user_id [description]
	 * @return {[type]}         [description]
	 */
	showDeleteUserModal: function(user_id)
	{
		$('.modal').modal({
			backdrop: 'static',
			keyboard: false
		});

		$('.modal .modal-header').addClass('bg-dark text-white');
		$('.modal .modal-title').empty().append('Delete User');
		$('.modal .modal-body').empty();

		var content = '';

		$.ajax({
			url: window.location.origin + '/get-user-details',
			data: { 'user_id' : user_id },
		})
		.done(function(response) {
			content = '<p class="font-weight-bold display-6 mb-0">Are you sure you want to want to delete this user? </p>';
			$('.modal .modal-body').append(content);
		});

		var delete_user = "usersPageFunctions.deleteUser('"+user_id+"')";
		var button_container = '<button type="button" class="btn btn-sm btn-success" data-dismiss="modal" onclick="'+delete_user+'"><i class="fas fa-user-slash"></i> Yes</button>\
								<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> No</button>';
		$('.modal .modal-footer').empty().append(button_container);
	},

	/**
	 * [deleteUser description]
	 * @param  {[type]} user_id [description]
	 * @return {[type]}         [description]
	 */
	deleteUser: function(user_id)
	{
		$.ajax({
			url: window.location.origin + '/delete-user',
			data: { 
				'user_id' : user_id,
			},
		})
		.done(function(response) {
			if(response == true) {
				$('.alert').addClass('alert-success').empty().append('User Successfully Deleted.');
				usersPageFunctions.repopulateUserTable();
			}
			else {
				$('.alert').addClass('alert-danger').empty().append('User Failed to be Deleted.');	
			}
			setTimeout(function() { 
				$('.alert').empty().removeClass('alert-danger alert-success').toggleClass('hidden');
			}, 5000);
		});
	}
}