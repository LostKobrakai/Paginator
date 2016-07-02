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
		// Does currently not support selectors with or-groups in it
		return wire('pages')->count('(id=[' . implode(']), (id=[', $selectors) . '])');
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
		// Keep set total untouched
		$total = $storage->getTotal();
		$storage->import($items);
		$storage->setTotal($total);

		return $storage;
	}
}