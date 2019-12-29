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
	resetSelectPicker: function()
	{
		$('.selectpicker').val('').selectpicker('refresh');
		$('#save-schedule').attr('disabled',true);
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

				$('#time-display-container').removeClass('d-none').addClass('d-grid');
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

				$('#time-display-container').addClass('d-none').removeClass('d-grid');
				$('#working-days-display thead th').removeAttr('class');
			}
		});
	}
}