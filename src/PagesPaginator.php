<?php

class PagesPaginator extends Paginator{
	protected function getStorage($start, $limit, $total)
	{
		return (new PageArray())
			->setStart($start)
			->setLimit($limit)
			->setTotal($total);
	}

	protected function getTotal($selectors){
		return wire('pages')->count('(' . implode('), (', $selectors) . ')');
	}

	protected function getNumberOfItemsForSelector($selector){
		return wire('pages')->count($selector);
	}

	protected function getItems($selector, $key, $start, $limit, $storage)
	{
		return wire('pages')->find($selector . ", start=$start, limit=$limit");
	}

	protected function addToStorage($storage, $items)
	{
		return $storage->import($items);
	}
}