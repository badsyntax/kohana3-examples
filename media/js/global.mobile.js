(function($, document){

	// set global vars
	(function setVars(){

		window._environment = /\bproduction\b/.test( document.documentElement.className ) 
			? 'production' 
			: 'development';
	})();

	// document ready
	$(function(){

	});

})(this.jQuery, document);
