<?php

/**
 * Class Paginator
 */
abstract class Paginator{

	/**
	 * Supply an array of selectors and get back paginated items from the concatinated results of all the selectors
	 *
	 * @param array $selectors Some kind of selectors as array
	 * @param int $pageNum Current page starting on 1
	 * @param int $limit The number of items of each page
	 * @return mixed $storage
	 */
	public function __invoke($selectors, $pageNum, $limit){
		$pageNum -= 1; // Zero-based
		$total = $this->getTotal($selectors);
		$lastKeyOfAll = $this->getTotal($selectors) - 1; // Zero based
		$start = $pageNum * $limit;

		if($start > $lastKeyOfAll) return [];

		$storage = $this->getStorage($start, $limit, $total);

		foreach ($selectors as $key => $selector) {
			$currentNumberOfIterms = $this->getNumberOfItemsForSelector($selector);

			if($currentNumberOfIterms > $start){
				$toBeStoredSet = $this->getItems($selector, $key, $start, $limit, $storage);
				$storage = $this->addToStorage($storage, $toBeStoredSet);
				$start = 0; // All not needed 
				$limit -= count($toBeStoredSet);
			}else{
				$start -= $currentNumberOfIterms;
			}

			if(!$limit) return $storage;
		}

		return $storage;
	}

	/**
	 * Retrieve the total number of items for the supplied selectors
	 *
	 * @param array $selectors
	 * @return int
	 */
	abstract protected function getTotal($selectors);

	/**
	 * Return the intended storage type to be used.
	 *
	 * @param int $start The item to start with for the current page
	 * @param int $limit The limit
	 * @param int $total The total number of items available from selectors
	 * @return mixed
	 */
	abstract protected function getStorage($start, $limit, $total);

	/**
	 * Return the number of items for the given selector
	 *
	 * @param mixed $selector
	 * @return int
	 */
	abstract protected function getNumberOfItemsForSelector($selector);

	/**
	 * Get the items for the current selector according to the start and limit.
	 * The current selectors index as well as the storage obj might be handy.
	 *
	 * @param mixed $selector
	 * @param int $key
	 * @param int $start
	 * @param int $limit
	 * @param mixed $storage
	 * @return mixed
	 */
	abstract protected function getItems($selector, $key, $start, $limit, $storage);

	/**
	 * Add the found items to the storage and return it
	 *
	 * @param mixed $storage
	 * @param mixed$items
	 * @return mixed
	 */
	abstract protected function addToStorage($storage, $items);
}