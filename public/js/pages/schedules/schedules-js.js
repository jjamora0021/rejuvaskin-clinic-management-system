/**
 * [schedulesFunctions description]
 * @type {Object}
 */
schedulesFunctions = {
	/**
	 * [onLoad description]
	 * @return {[type]} [description]
	 */
	onLoad: function()
	{
		generalFunctions.determinePage('dashboard-dropdown');
		schedulesFunctions.initializeSelectPicker();
		schedulesFunctions.initializeTimePicker();
	},

	/**
	 * [initializeSelectPicker description]
	 * @return {[type]} [description]
	 */
	initializeSelectPicker: function()
	{
		$('select').selectpicker();
	},

	/**
	 * [initializeTimePicker description]
	 * @return {[type]} [description]
	 */
	initializeTimePicker: function()
	{
        var dateNow = new Date();
		$('#time-in').datetimepicker({
			format: 'LT',
		    defaultDate:moment(dateNow).hours(9).minutes(0).seconds(0).milliseconds(0)
		});

		$('#time-out').datetimepicker({
			format: 'LT',
		    defaultDate:moment(dateNow).hours(18).minutes(0).seconds(0).milliseconds(0)
		});
	},

	/**
	 * [displaySelected description]
	 * @return {[type]} [description]
	 */
	displaySelected: function(id)
	{
		var working = $('#working-days').val();
		var rest = $('#rest-days').val();
		
		$('input[name="working-days"').val(working);
		$.each(working, function(key, value) {
			$('#working-days-display thead th#'+value).addClass('bg-success font-weight-bold text-white');
		});

		$('input[name="rest-days"').val(rest);
		$.each(rest, function(key, value) {
			$('#working-days-display thead th#'+value).addClass('bg-danger font-weight-bold text-white');
		});		
		
		$('#save-schedule').attr('disabled',false);
	},


	/**
	 * [resetSelectPicker description]
	 * @return {[type]} [description]
	 */
	resetSelectPicker: function(id)
	{
		$(id+' .selectpicker').val('').selectpicker('refresh');
		$(id+' #save-schedule').attr('disabled',true);

		$(id+' #working-days, #time-in input, #time-in .input-group-text, #time-out input, #time-out .input-group-text, #rest-days ,#verify-schedule-btn').removeAttr('disabled');
		$(id+' .selectpicker').selectpicker('refresh');

		$(id+' #time-display-container > div').addClass('d-none').removeClass('d-flex');
		$(id+' #working-days-display thead th').removeAttr('class');
	},

	/**
	 * [toggleAlert description]
	 * @return {[type]} [description]
	 */
	toggleAlert: function()
	{
		$('.alert').fadeOut(5000);
		setTimeout(function() {
			$('.alert').removeClass('.alert-success');
		}, 5000);
	},

	/**
	 * [getStaffSchedule description]
	 * @param  {[type]} user_id [description]
	 * @return {[type]}         [description]
	 */
	getStaffSchedule: function(id)
	{
		var user_id = $(id).val();
		
		$.ajax({
			url: window.location.origin + '/get-staff-schedule',
			data: { 'user_id' : user_id },
		})
		.done(function(response) {
			var working_days = response['days_working'];
			var days_off = response['days_off'];
			var time_in = response['time_in'];
			var time_out = response['time_out'];

			if(response.length != 0) {
				$('#working-days, #time-in input, #time-in .input-group-text, #time-out input, #time-out .input-group-text, #rest-days ,#verify-schedule-btn').attr('disabled',true);
				$('.selectpicker').selectpicker('refresh');

				$('#time-display-container > div').removeClass('d-none').addClass('d-flex');
				$('#time-in-container #time-in-display').empty().text(response['time_in']);
				$('#time-out-container #time-out-display').empty().text(response['time_out']);

				$.each(response['days_working'], function(index, el) {
					$('#working-days-display th#'+el).removeAttr('class').addClass('bg-success text-white font-weight-bold');
				});

				$.each(response['days_off'], function(index, el) {
					$('#working-days-display th#'+el).removeAttr('class').addClass('bg-danger text-white font-weight-bold');
				});				
			}
			else {
				$('#working-days, #time-in input, #time-in .input-group-text, #time-out input, #time-out .input-group-text, #rest-days ,#verify-schedule-btn').removeAttr('disabled');
				$('.selectpicker').selectpicker('refresh');

				$('#time-display-container > div').addClass('d-none').removeClass('d-flex');
				$('#working-days-display thead th').removeAttr('class');
			}
		});
	},

	repopulateHolidayTable: function()
	{
		$('#holiday-list-table tbody').empty();
		$.ajax({
			url: window.location.origin + '/get-all-holidays',
		})
		.done(function(response) {
			console.log(response);
			if(response.length != 0) {
				$.each(response, function(key, el) {
					var holiday_update_btn = "schedulesFunctions.showUpdateHolidayModal('"+el["id"]+"')";
					var holiday_delete_btn = "schedulesFunctions.showDeleteHolidayModal('"+el["id"]+"')";
					var rows = '<tr>\
									<td hidden>'+el["id"]+'</td>\
									<td>'+el["holiday"]+'</td>\
									<td class="text-center">'+el["date"]+'</td>\
									<td class="text-center">\
										<button type="button" class="btn btn-sm btn-info" onclick="'+holiday_update_btn+'"><i class="fas fa-edit"></i> Update</button>\
										<button type="button" class="btn btn-sm btn-danger" onclick="'+holiday_delete_btn+'"><i class="fas fa-trash-alt"></i> Delete</button>\
									</td>\
								</tr>';
					$('#holiday-list-table tbody').append(rows);
				})
			}
			else {
				$('#holiday-list-table tbody').append('<tr><td colspan="3" class="text-center font-weight-bold">There are no HOLIDAYS recorded.</td></tr>')
			}
		});
	},

	/**
	 * [showUpdateModal description]
	 * @param  {[type]} holiday_update [description]
	 * @return {[type]}                [description]
	 */
	showDeleteHolidayModal: function(holiday_id)
	{
		$('.modal').modal({
			backdrop: 'static',
			keyboard: false
		});

		$('.modal .modal-header').addClass('bg-dark text-white');
		$('.modal .modal-title').empty().append('Delete Holiday');
		$('.modal .modal-body').empty();

		var content = '<p class="font-weight-bold display-6 mb-0">Are you sure you want to want to delete this holiday? </p>';
		$('.modal .modal-body').append(content);

		var delete_holiday = "schedulesFunctions.deleteHoliday('"+holiday_id+"')";
		var button_container = '<button type="button" class="btn btn-sm btn-success" data-dismiss="modal" onclick="'+delete_holiday+'"><i class="fas fa-check"></i> Yes</button>\
								<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> No</button>';
		$('.modal .modal-footer').empty().append(button_container);
	},

	/**
	 * [deleteHoliday description]
	 * @param  {[type]} id [description]
	 * @return {[type]}    [description]
	 */
	deleteHoliday: function(id)
	{
		$.ajax({
			url:  window.location.origin + '/delete-holiday',
			data: {
				'id' : id
			},
		})
		.done(function(response) {
			if(response == true) {
				$('#holiday-table-container .alert').addClass('alert-success').empty().append('Holiday Successfully Deleted.');
				schedulesFunctions.repopulateHolidayTable();
			}
			else {
				$('#holiday-table-container .alert').addClass('alert-danger').empty().append('Holiday Failed to be Deleted.');	
			}
			setTimeout(function() { 
				$('#holiday-table-container .alert').empty().removeClass('alert-danger alert-success').toggleClass('hidden');
			}, 5000);
		});
	}
}