<p>
	The page demonstrates how to use AJAX in your Kohana 3 application.
	Only the template contents will be used for the response body of an ajax request, 
	the html data type example demonstrates this.
</p>

<h2>Data type examples</h2>

<ul>
	<li><a id="html-link" href="<?php echo URL::site('ajax/html')?>">HTML</a></li>
	<li><a id="xml-link" href="<?php echo URL::site('ajax/xml')?>">XML</a></li>
	<li><a id="json-link" href="<?php echo URL::site('ajax/json')?>">JSON</a></li>
</ul>

<div id="example" style="border:1px solid #eee;padding: 1em;">

</div>

<script type="text/javascript">


(function($){

	$('#html-link').click(function(e){

		e.preventDefault();

		$('#example').load( this.href );
	});

	$('#xml-link').click(function(e){

		e.preventDefault();

		$.ajax({
			type: 'GET',
			url: this.href,
			dataType: 'xml',
			success: function(xmldoc){

				var element = $('#example').html('<p>XML results:</p>');

				$(xmldoc).find('book').each(function(){

					var title = $(this).find('title').text(),
						author = $(this).find('author').text();

					element.append('<div>Title: ' + title + ' Author: ' + author);
				});
			}
		});
	});

	$('#json-link').click(function(e){

		e.preventDefault();

		$.getJSON(this.href, function(data){

			var element = $('#example').html('<p>JSON results:</p>');

			$.each(data, function(key, val){

				element.append('<div>' + key + ': ' + val + '</div>');
			});
			
		});
	});

})(this.jQuery);

</script>
