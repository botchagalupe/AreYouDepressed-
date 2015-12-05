@extends('layouts.default')

@section('content')

<div class="admin-panel">
	{!! Form::open( array('route' => 'handleAdmin', 'method' => 'post', 'class' => 'row col s12') ) 		!!}
		
		<div class="col m4 offset-m4 white">
			
			<br />
			@foreach ($errors->all() as $message)
			    <li>{{ $message }}</li>
			@endforeach
			<div class="row">
				<h3 class="col s12 center"> Are you depressed? </h3>
			</div>

			<div class="row">
				<div class="input-field col s12">
					{!! Form::label('password','Password')									!!}
					{!! Form::password('password', null,array('class' => 'twelve columns'))	!!}
				</div>
			</div>
			<div class="row">
				<div class="col s12">
					<button class="btn waves-effect waves-light col m5 s6 blue" type="submit" name="choice" value="yes">Yes
						<i class="mdi-content-send right"></i>
					</button>
					<button class="btn waves-effect waves-light col m5 s6 offset-m2 red" type="submit" name="choice" value="no">No
						<i class="mdi-content-send right"></i>
					</button>
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12">
					<button class="btn waves-effect waves-light col m12 s12 green" type="button" onclick="$('#extra-options').fadeIn(2000); $(this).hide();">Show Extra Options
					</button>
				</div>
			</div>


			<div id="extra-options">
				<div class="row">
					<div class="input-field col s12">
						<h5>Password field required for all below</h5><br />
						<h5> I do not want emails between (24hr): </h5>
						{!! Form::text('lower_bound', \App\Setting::where('name', 'email_period_lower_bound')->first()->setting,array('class' => 'col s3'))	!!} 
						<div class="col s1 rightarrow">&#8594;</div>
						{!! Form::text('upper_bound',\App\Setting::where('name', 'email_period_upper_bound')->first()->setting,array('class' => 'col s3 offset-s1'))	!!}
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12">
						{!! Form::label('name','My name is...')									!!}
						{!! Form::text('name', \App\Setting::where('name', 'name')->first()->setting,array('class' => 'twelve columns'))	!!}
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12">
						{!! Form::label('email','My email is...')									!!}
						{!! Form::text('email', \App\Setting::where('name', 'email')->first()->setting,array('class' => 'twelve columns'))	!!}
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12">
						<h5>You can set a new password by visiting <a href="{{ URL::route('password') }}">this link</a> (it will take it from the .env file)</h5>
						<br />
						<button class="btn waves-effect waves-light col m12 s12 green" type="submit" name="settings" value="being-set">Update Settings
							<i class="mdi-content-send right"></i>
						</button>
					</div>
				</div>
			</div>
		</div>

	{!! Form::close() 													!!}
</div>
@stop
