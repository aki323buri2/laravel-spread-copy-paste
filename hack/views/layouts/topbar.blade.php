@extends('layouts/master')
@push('styles')
<style>
.ui.menu .search.input input:first-child
{
	border-radius: 1rem;
	padding-left: 1rem;
}
.ui.menu .search.input input:first-child + i.icon
{
	right: .5rem;
}
.ui.menu .header.item > .icon
{
	width: 1.5rem;
	margin-right: .5rem;
}
</style>
@endpush
@section('topbar')
<div class="ui menu">
	<a href="{{ url('/') }}" class="header item">
		<img src="{{ url('/images/okuwa.ico') }}" alt="" class="icon">
		オークワギフト
	</a>
	<a href="{{ url('/home') }}" class="item">
		<i class="home icon"></i>
		Home
	</a>
	<a href="{{ url('/catalog') }}" class="item">
		<i class="book icon"></i>
		商品カタログ
	</a>

	<div class="ui right menu">
		<div class="item">
			<div class="ui icon input search">
				<input type="text" placeholder="Search">
				<i class="search link icon"></i>
			</div>
		</div>
		<a href="#" class="item">
			<user class="icon"></user>
			<i class="user icon">	</i>
			Link
		</a>
	</div>
</div>
@endsection