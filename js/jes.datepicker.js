// AJAX Functions
	var jqd = jQuery;
	jqd(document).ready(function($) {
		$("#event-edtsd").datepicker(
			{
				changeMonth: true,
				changeYear: true,
				yearRange: '2010:2020',
				gotoCurrent: true
			});
		$("#event-edted").datepicker(
			{
				changeMonth: true,
				changeYear: true,
				yearRange: '2010:2020',
				gotoCurrent: true
			});		
	});