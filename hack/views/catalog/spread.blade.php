@extends('layouts/sidebar')
@section('title', '商品カタログ - 表形式')
<?php
$links_more = array_merge((array)@$link_more, [
	'/vendor/handsontable/dist/handsontable.full.css', 
	'/vendor/handsontable/dist/handsontable.full.js', 
]);

$columns = collect($catalog->getColumns());
$names = $columns->keys();
foreach ((array)$cache as $row)
{
	$objects[] = (object)array_combine($names->toArray(), $row);
}
?>
@push('styles')
<style>
#handson .catno { width: 80px; }
#handson .shcds { width: 80px; }
#handson .eoscd { width: 80px; }
#handson .mekame { width: 150px; }
#handson .shiren { width: 60px; }
#handson .hinmei { width: 250px; }
#handson .sanchi { width: 100px; }
#handson .tenyou { width: 100px; }
#handson .nouka { width: 90px; }
#handson .baika { width: 90px; }
#handson .stanka { width: 90px; }
</style>
@endpush
@section('content')
<p>
	商品カタログ - 表形式で一括編集
</p>
<div id="handson"></div>
@endsection
@push('scripts')
<script>
$(function ()
{
	var data = [];
	var object;
	@foreach ($objects as $object)
		object = {};
		@foreach($object as $name => $value)
			object.{{ $name }} = '{{ $value }}';
		@endforeach 
		data.push(object);
	@endforeach
	console.log(data);

	var hot = handson($('#handson'));
	hot.selectCell(0, 0);
	
	function handson(el)
	{
		var hat = el.handsontable({
			columns: columns()
			, afterChange: afterChange
			, data: data
		});
		return hat.handsontable('getInstance');
	}
	function columns()
	{
		var columns = [];
		var column;
		@foreach ($columns as $name => $column)
			column = {};
			column.title     = '{{ $column->title }}';
			column.data      = '{{ $column->name  }}';
			column.type      = '{{ $column->hot   }}';
			column.className = '{{ $column->name  }}';
			columns.push(column);
		@endforeach
		return columns;
	}
	function afterChange(changes, source)
	{
		if (source === 'loadData') return;

		var data = hot.getData();

		$.ajax({
			url: '/catalog/session'
			, method: 'post'
			, data: {
				name: 'spread-cache'
				, _token: '{{ csrf_token() }}'
				, data: data
			}
		})
		.done(function (data)
		{
			console.log(data);
		});
	}
});
</script>
@endpush