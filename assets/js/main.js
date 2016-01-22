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
	});
	jQuery(window).load(function() {
		jQuery('body').removeClass('no-js').addClass('loaded');
	});
}());