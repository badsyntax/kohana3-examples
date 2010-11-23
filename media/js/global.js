(function($, document){

	// html5-shim by @kangax
	/*@cc_on(function(e,i){i=e.length;while(i--)document.createElement(e[i])})("abbr,article,aside,audio,canvas,details,figure,footer,header,hgroup,mark,menu,meter,nav,output,progress,section,time,video".split(','))@*/

	// add 'js' classname to <html> tag
	(function setJs(){

		var classes = document.documentElement.className.split(' ');

		classes.push('js');

		document.documentElement.className = classes.join(' ');
	})();

	// set global vars
	(function setVars(){

		window._environment = /\bproduction\b/.test( document.documentElement.className ) 
			? 'production' 
			: 'development';
	})();

	// bind profiler click event handler
	function profiler(){
		
		var 
			profiler = $('#profiler-container'), 
			anchor = $('a[href="#profiler"]');

		profiler.length && anchor.length && anchor
			.click(function(){
	
				// show/hide the profiler
				profiler.fadeToggle('fast');

				// toggle the show/hide icon
				anchor.find('span').toggle();
			});
	}
		
	// document ready
	$(function(){

		profiler();
	});

})(this.jQuery, document);
