@extends('layouts.default')

@section('content')
	@foreach ($errors->all() as $message)
		{{$message}}
	@endforeach
	{!! Form::open( array('route' => 'handleAdmin', 'method' => 'post', 'class' => 'row col s12') ) 		!!}
		<h2> Are you depressed? </h2>
		<div class="row">
			<div class="input-field col s12 m4 offset-m4">
				{!! Form::label('password','Password')									!!}
				{!! Form::password('password', null,array('class' => 'twelve columns'))	!!}
			</div>
		</div>
		<div class="row">
			<button class="btn waves-effect waves-light" type="submit" name="choice" value="yes">Yes
				<i class="mdi-content-send right"></i>
			</button>
			<button class="btn waves-effect waves-light" type="submit" name="choice" value="no">No
				<i class="mdi-content-send right"></i>
			</button>
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

@stop
