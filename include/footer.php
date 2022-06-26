  </div>
  	<script src="assets/jquery-ui-1.13.0/external/jquery/jquery.js"></script>
  	<script src="assets/jquery-ui-1.13.0/jquery-ui.js"></script>
	<script type="text/javascript">
		flatpickr('#t_start_time', {
			enableTime: true
		});
		flatpickr('#t_end_time', {
			enableTime: true
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#txtcardid").autocomplete({
				source: 'search.php',
				minLength: 0,
			});
			$("#taskcardid").autocomplete({
				source: 'searchclients.php',
				minLength: 0,
			});
		});
	</script>
	<script>
		setInterval(() => {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","response.php",false);
			xmlhttp.send(null);
			document.getElementById("response").innerHTML = xmlhttp.responseText;
		}, 1000);
	</script>
</body>
</html>