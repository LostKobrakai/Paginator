<?php

class PagesPaginator extends Paginator{

	public function getStorage($start, $limit, $total)
	{
		return (new PageArray())
			->setStart($start)
			->setLimit($limit)
			->setTotal($total);
	}

	function getTotal($selectors){
		return wire('pages')->count('(' . implode('), (', $selectors) . ')');
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