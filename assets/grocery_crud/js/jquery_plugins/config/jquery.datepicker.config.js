$(function(){
	$('.datepicker-input').datepicker({
			format: "dd/mm/yyyy",
			clearBtn : true,
			todayHighlight : true,
			autoclose : true
	});
	
	$('.datepicker-input-clear').button();
	
	$('.datepicker-input-clear').click(function(){
		$(this).parent().find('.datepicker-input').val("");
		return false;
	});
	
});