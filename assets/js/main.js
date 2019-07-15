(function () {
	'use strict';
   
	function triggerSelect() {
		var mySelect = jQuery('select:not(.normal-select)');
		mySelect.each(function(){
			jQuery(this).addClass('has-styled-select').wrap('<span class="styled-select"></span>');
		});
		
	}
   
	jQuery(document).ready(function() {
		triggerSelect();
		jQuery('.field-from-datepicker').pickadate({
			onSet: function(date) {
				var d = new Date(date.select);
				var day = d.getDate(),
					month = d.getMonth() + 1,
					year = d.getFullYear();
					
				jQuery('#field-from-dd').val(day);
				jQuery('#field-from-mm').val(month);
				jQuery('#field-from-yyyy').val(year);

			}
		});
		jQuery('.field-to-datepicker').pickadate({
			onSet: function(date) {
				var d = new Date(date.select);
				var day = d.getDate(),
					month = d.getMonth() + 1,
					year = d.getFullYear();
					
				jQuery('#field-to-dd').val(day);
				jQuery('#field-to-mm').val(month);
				jQuery('#field-to-yyyy').val(year);

			}
		});
		jQuery('.field-datepicker').pickadate({
			onSet: function(date) {
				var d = new Date(date.select);
				var day = d.getDate(),
					month = d.getMonth() + 1,
					year = d.getFullYear();
					
				jQuery('#field-dd').val(day);
				jQuery('#field-mm').val(month);
				jQuery('#field-yyyy').val(year);

			}
		});
		jQuery('#change-year select#year').on('change', function() {
			var $form = jQuery(this).closest('form');
			$form.submit();
		});
	});
	jQuery(window).load(function() {
		jQuery('body').removeClass('no-js').addClass('loaded');
	});
}());