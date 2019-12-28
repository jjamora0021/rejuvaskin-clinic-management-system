/**
 * [timeKeepingFunctions description]
 * @type {Object}
 */
timeKeepingFunctions = {
	/**
	 * [onLoad description]
	 * @return {[type]} [description]
	 */
	onLoad: function()
	{
		generalFunctions.determinePage('dashboard-dropdown');
		generalFunctions.showTime();
		timeKeepingFunctions.getLatestTimeKeeping();
	},

	/**
	 * [scrollToDate description]
	 * @param  {[type]} date [description]
	 * @return {[type]}      [description]
	 */
	scrollToDate: function(date)
	{
		var container = $('#time-keeping-records-container');
		var scrollTo = $('#time-keeping-records-table tbody tr#'+date)
    	container.animate({
		    scrollTop: scrollTo.offset().top - container.offset().top + container.scrollTop()
		});
	},

	/**
	 * [getTimeDateHour description]
	 * @return {[type]} [description]
	 */
	getTimeDateHour: function()
	{
		var data = [];
		data['date'] = moment().format('YYYY-MM-DD');
		data['time'] = moment().format('HH:mm:ss');
		
		return data;
	},

	/**
	 * [getLatestTimeKeeping description]
	 * @return {[type]} [description]
	 */
	getLatestTimeKeeping: function()
	{
		$.ajax({
			url: window.location.origin + '/get-latest-time-keeping',
		})
		.done(function(response) {
			if(response != false) {
				if(response.hasOwnProperty('time_in') == true && response.hasOwnProperty('time_out') != true) {
					$('#time-in-button').attr('disabled',false);
					$('#time-out-button').attr('disabled',true);
				}
				else if(response.hasOwnProperty('time_in') == true && response.hasOwnProperty('time_out') == true) {
					$('#time-in-button').attr('disabled',true);
					$('#time-out-button').attr('disabled',true);
				}
				else {
					$('#time-in-button').attr('disabled',false);
					$('#time-out-button').attr('disabled',true);
				}	
			}
			else {
				$('#time-in-button').attr('disabled',false);
				$('#time-out-button').attr('disabled',true);
			}
		});
	},

	/**
	 * [saveTimeIn description]
	 * @return {[type]} [description]
	 */
	saveTimeIn: function()
	{
		var data_arr = timeKeepingFunctions.getTimeDateHour();
		var date = data_arr['date'].split("-")[2];
		
		$.ajax({
			url: window.location.origin + '/save-time-in',
			data: {
				'date' : data_arr['date'],
				'time' : data_arr['time']
			},
		})
		.done(function(response) {
			if(response == true) {
				$('#time-keeping-records-table tbody tr#'+date+' td.time-in').text(data_arr['time']);
				$('#time-keeping-records-table tbody tr#'+date+' td.hours').text(0);

				$('#time-keeping-records-card .alert').addClass('alert-success').toggleClass('d-none').empty().append('Time In logged successfully.');

				$('#time-in-button').attr('disabled',true);
				$('#time-out-button').attr('disabled',false);
				setTimeout(function() {
					$('#time-keeping-records-card .alert').removeClass('alert-success').toggle('d-none');
				}, 5000);
			}
		});
	},

	saveTimeOut: function()
	{
		var data_arr = timeKeepingFunctions.getTimeDateHour();
		var date = data_arr['date'].split("-")[2];
		
		$.ajax({
			url: window.location.origin + '/save-time-out',
			data: {
				'date' : data_arr['date'],
				'time' : data_arr['time']
			},
		})
		.done(function(response) {
			if(response != false || response != 'error') {
				$('#time-keeping-records-table tbody tr#'+date+' td.time-out').text(data_arr['time']);
				$('#time-keeping-records-table tbody tr#'+date+' td.hours').text(parseFloat(response).toFixed(2));

				$('#time-keeping-records-card .alert').addClass('alert-success').toggleClass('d-none').empty().append('Time Out logged successfully.');

				$('#time-in-button').attr('disabled',false);
				$('#time-out-button').attr('disabled',true);
				setTimeout(function() {
					$('#time-keeping-records-card .alert').removeClass('alert-success').toggle('d-none');
				}, 5000);
			}
			else if(response == 'error') {
				$('#time-keeping-records-card .alert').addClass('alert-danger').toggleClass('d-none').empty().append('Something went wrong. Please contact your administrator.');
				setTimeout(function() {
					$('#time-keeping-records-card .alert').removeClass('alert-danger').toggle('d-none');
				}, 5000);
			}
			else {
				$('#time-keeping-records-card .alert').addClass('alert-danger').toggleClass('d-none').empty().append('Something went wrong. Please contact your administrator.');
				setTimeout(function() {
					$('#time-keeping-records-card .alert').removeClass('alert-danger').toggle('d-none');
				}, 5000);
			}
		});
	}
}