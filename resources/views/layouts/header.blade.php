<!DOCTYPE html>
<html>
<head>
	<title>@yield('title', env('SITE_TITLE'))</title>
	<meta charset="utf-8">
	<meta name="description" content="@yield('description')" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<link rel="shortcut icon" href="{{ URL::to('/') }}/images/favicon.png">

	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/css/app.css">
	@yield('extra-css')


	@yield('extra-head')
</head>
<body class="{{ $depressionStatus or \App\Depression::orderBy('created_at', "DESC")->first()->is_depressed }}">
	<div id="particles-js"></div>
		<div class="valign-wrapper" >