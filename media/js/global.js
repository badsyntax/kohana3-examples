(function($, document){

	/* html5-shim by @kangax */
	/*@cc_on(function(e,i){i=e.length;while(i--)document.createElement(e[i])})("abbr,article,aside,audio,canvas,details,figure,footer,header,hgroup,mark,menu,meter,nav,output,progress,section,time,video".split(','))@*/
	
	document.documentElement.className += ' js';

	// document ready
	$(function(){
		
		var 
			profiler = $('#profiler-container'), 
			anchor = $('a[href="#profiler"]');

		profiler.length && anchor.length && anchor
			.click(function(){

				profiler.fadeToggle('fast');

				anchor.find('span').toggle();
			});
	});

})(this.jQuery, document);
