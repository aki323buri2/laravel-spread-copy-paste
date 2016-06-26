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
.paste.input > input[type="text"]
{
	width: 30rem;
}
#handson .catno { width: 80px; }
#handson .shcds { width: 80px; }
#handson .eoscd { width: 80px; }
#handson .mekame { width: 150px; }
#handson .shiren { width: 60px; }
#handson .hinmei { width: 250px; }
#handson .sanchi { width: 120px; }
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
<div class="ui left icon input paste">
	<i class="paste icon"></i>
	<input type="text" id="paste" placeholder="ここを右クリックして貼り付けをクリックしてください">
</div>
<div id="handson"></div>
@endsection
@push('scripts')
<script>
$(function ()
{
	var paste = $('#paste');
	var hot = handson($('#handson'));

	applyCacheDatat(hot);
	applyCopyPasteByClick(hot, paste);

	hot.selectCell(0, 0);

	function handson(el)
	{
		var hat = el.handsontable({
			columns: columns()
			, afterChange: afterChange
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
	function applyCacheDatat(hot)
	{
		$(function ()
		{
			$.ajax({
				url: '/catalog/session'
				, method: 'get'
				, data: {
					name: 'spread-cache'
				}
			})
			.done(function (data)
			{
				data = JSON.parse(data);
				if (data.length === 0) return;
				hot.populateFromArray(0, 0, data);
			});
		});
	}
	function applyCopyPasteByClick(hot, paste)
	{
		paste.on('paste', function (e)
		{
			e.preventDefault();
			e.stopPropagation();
			var clipboardData = e.clipboardData || e.originalEvent.clipboardData;
			var format = 'text/plain';
			if (clipboardData === undefined)
			{
				//IE..
				clipboardData = window.clipboardData;
				format = 'text';
			}
			var data = clipboardData.getData(format);
			
			hot.selectCell(0, 0);
			hot.updateSettings({data: [[]]});
			hot.copyPaste.triggerPaste(null, data);
		});
	}
});
</script>
@endpush