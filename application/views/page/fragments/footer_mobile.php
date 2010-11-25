<div data-role="footer"  class="ui-bar">
	<select name="site-mode" id="site-mode" data-theme="a">
		<option value="mobile">Mobile</option>
		<option value="classic">Classic</option>
	</select>
</div>
<script type="text/javascript">
(function($){
$('#site-mode').change(function(){
	window.location = this.value === 'mobile' 
		? '<?php echo URL::base(TRUE, TRUE)?>' 
		: '<?php echo str_replace('mobile.', '', URL::base(TRUE, TRUE))?>';
});
})(this.jQuery);
</script>
