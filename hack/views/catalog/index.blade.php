@extends('layouts/sidebar')
@section('title', '商品カタログ')
@section('content')
<p>
	商品カタログ
</p>
<table class="ui celled table">
	<thead>
		<tr>
			@foreach ($catalog->getColumns() as $name => $column)
				<th class='{{ $name }}'
					data-name='{{ $column->name }}'
				>
					{{ $column->title }}					
				</th>
			@endforeach
		</tr>
	</thead>
</table>
@endsection
@push('scripts')
<script>
$(function ()
{
	$.each([
		['表形式で一括編集', 'grid layout', '/catalog/spread']
	], function (index, item)
	{
		var i = 0;
		var no = index + 1;
		var title = item[i++];
		var icon = item[i++];
		var href = item[i++];
		$('#sidemenu' + no)
			.text(title)
			.append($('<i>').addClass(icon + ' icon'))
			.prop('href', href)
		;
	});
});
</script>
@endpush