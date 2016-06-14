<?php

class PagesPaginator extends Paginator{

	function getLastKey($selectors){
		return wire('pages')->count('(' . implode('), (', $selectors) . ')') - 1;
	}

	function getNumberOfItemsForSelector($selector){
		return wire('pages')->count($selector);
	}

	public function getItems($selector, $key, $start, $limit)
	{
		return wire('pages')->find($selector . ", start=$start, limit=$limit");
	}

	public function addToStorage($storage, $items)
	{
		return $storage->import($items);
	}
}