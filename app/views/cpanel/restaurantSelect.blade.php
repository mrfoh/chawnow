@extends('cpanel.layouts.login')

@section('title')
Select a restaurant
@stop

@section('content')
<div class="select-screen">
	<div class="container">

		<div class="logo"></div>

		<h2>Select a restaurant to manage</h2>

		<div class="restaurant-box">
			<ul class="restaurant-list">
			@foreach($restaurants as $restaurant)
				<li>
					<a href="/restaurant-select/{{ $restaurant->restaurant->id }}">{{ $restaurant->restaurant->name }}</a>
				</li>
			@endforeach
			</ul>
		</div>
	</div>
</div>
@stop