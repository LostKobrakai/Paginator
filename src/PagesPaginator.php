<?php

/**
 * Class PagesPaginator
 */
class PagesPaginator extends Paginator{

	/**
	 * @param int $start
	 * @param int $limit
	 * @param int $total
	 * @return PageArray
	 */
	protected function getStorage($start, $limit, $total)
	{
		return (new PageArray())
			->setStart($start)
			->setLimit($limit)
			->setTotal($total);
	}

	/**
	 * @param array $selectors
	 * @return int
	 */
	protected function getTotal($selectors){
		// Does currently not support selectors with or-groups in it
		return wire('pages')->count('(id=[' . implode(']), (id=[', $selectors) . '])');
	}

	/**
	 * @param string $selector
	 * @return int
	 */
	protected function getNumberOfItemsForSelector($selector){
		return wire('pages')->count($selector);
	}

	/**
	 * @param string $selector
	 * @param int   $key
	 * @param int   $start
	 * @param int   $limit
	 * @param PageArray $storage
	 * @return PageArray
	 */
	protected function getItems($selector, $key, $start, $limit, $storage)
	{
		return wire('pages')->find($selector . ", start=$start, limit=$limit");
	}

	/**
	 * @param PageArray $storage
	 * @param PageArray $items
	 * @return PageArray
	 */
	protected function addToStorage($storage, $items)
	{
		// Keep set total untouched
		$total = $storage->getTotal();
		$storage->import($items);
		$storage->setTotal($total);

		return $storage;
	}
}