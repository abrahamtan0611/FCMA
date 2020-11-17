
<footer>
<div class="footer" id="footer">
	<div class="container">
		<div class="row">
			<div class="footer-col-1">
				<h1>FoodEdge</h1>
			</div>
			<div class="footer-col-2">
				<h3>Useful Links</h3>
				<ul>
					<li><a href="feedback.php">Give Feedbacks</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
</footer>

<script>
	function autoHeight(){
		$('#content').css('min-height',0);
		$('#content').css('min-height',(
			$(document).height()
				- $('#header_c').height()
				- $('#footer').height()	
			))
	}
	
	$(document).ready(function(){
		autoHeight();
	});
</script>

</body>
</html>

