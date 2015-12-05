@extends('layouts.default')


@section('content')
	<div class="row valign">
		<h2 class="quote">Is {{ \App\Setting::where('name', 'name')->first()->setting }} depressed?</h2>
		<h1 class="center title">{{ strtoupper( $depressionStatus ) }}</h1>
	</div>
@stop