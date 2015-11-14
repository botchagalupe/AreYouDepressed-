@extends('layouts.default')


@section('content')
	<div class="row valign">
		<h2 class="quote">Is {{ env('NAME') }} depressed?</h2>
		<h1 class="center title">{{ strtoupper( $depressionStatus ) }}</h1>
	</div>
@stop