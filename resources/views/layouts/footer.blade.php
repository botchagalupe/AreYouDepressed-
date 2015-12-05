		
	</div>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/js/materialize.min.js"></script>
	<script type="text/javascript" src="{{ URL::to('/') }}/js/app.js"></script>
	@yield('extra-js')

	<script type="text/javascript">


	$(document).ready(function(){
		@if( \App\Depression::orderBy('created_at', "DESC")->first()->is_depressed == 'yes' )
			particlesJS.load('particles-js', 'sluggish.json', function() {});
		@else
			particlesJS.load('particles-js', 'energetic.json', function() {});
		@endif
	});
	</script>
</body>
</html>