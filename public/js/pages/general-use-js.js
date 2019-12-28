/**
 * [generalFunctions description]
 * @type {Object}
 */
generalFunctions = {
	/**
	 * [determinePage description]
	 * @param  {[type]} url [description]
	 * @return {[type]}     [description]
	 */
	determinePage: function(system_module)
	{
		var url = window.location.pathname;
		var page = url.substring(1, url.length);

		generalFunctions.activateSidebarLink(system_module, page);
	},

	/**
	 * [activateSidebarLink description]
	 * @param  {[type]} system_module [description]
	 * @param  {[type]} link          [description]
	 * @return {[type]}               [description]
	 */
	activateSidebarLink: function(system_module, link)
	{
		$('#'+system_module).trigger('click');
		$('#'+link+'-link').addClass('hovered');
	},

	/**
	 * [showTime description]
	 * @return {[type]} [description]
	 */
	showTime: function()
	{
		var date = new Date();
	    var h = date.getHours(); 
	    var m = date.getMinutes(); 
	    var s = date.getSeconds(); 
	    var session = "AM";
	    
	    if(h == 0){
	        h = 12;
	    }
	    
	    if(h > 12){
	        h = h - 12;
	        session = "PM";
	    }
	    
	    h = (h < 10) ? "0" + h : h;
	    m = (m < 10) ? "0" + m : m;
	    s = (s < 10) ? "0" + s : s;
	    
	    var time = h + ":" + m + ":" + s + " " + session;
	    document.getElementById("time-keeping-clock").innerText = time;
	    document.getElementById("time-keeping-clock").textContent = time;
	    
	    setTimeout(generalFunctions.showTime, 1000);
	},
}