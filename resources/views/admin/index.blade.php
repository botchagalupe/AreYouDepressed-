@extends('layouts.default')

@section('content')

<div class="admin-panel">
	@foreach ($errors->all() as $message)
		{{$message}}
	@endforeach
	{!! Form::open( array('route' => 'handleAdmin', 'method' => 'post', 'class' => 'row col s12 valign') ) 		!!}
		<div class="row">
			<h2 class="col s12 m6 offset-m4"> Are you depressed? </h2>
		</div>

		<div class="row">
			<div class="input-field col s12 m4 offset-m4">
				{!! Form::label('password','Password')									!!}
				{!! Form::password('password', null,array('class' => 'twelve columns'))	!!}
			</div>
		</div>
		<div class="row">
			<div class="col s12 m4 offset-m4">
				<button class="btn waves-effect waves-light col m5 s6 blue" type="submit" name="choice" value="yes">Yes
					<i class="mdi-content-send right"></i>
				</button>
				<button class="btn waves-effect waves-light col m5 s6 offset-m2 red" type="submit" name="choice" value="no">No
					<i class="mdi-content-send right"></i>
				</button>
			</div>
		</div>

{{-- 	<div class="row">
		<div class="input-field">
			{!! Form::label('email','Email')									!!}
			{!! Form::text('email', null,array('class' => 'twelve columns'))	!!}
		</div>
	</div>

	<div class="row">
		<div class="input-field">
			{!! Form::label('password','Password')								!!}
			{!! Form::password('password',array('class' => 'twelve columns'))	!!}
		</div>
	</div>

	<button class="btn waves-effect waves-light" type="submit" name="action">Login
		<i class="mdi-content-send right"></i>
	</button>
 --}}
	{!! Form::close() 													!!}
</div>
@stop
