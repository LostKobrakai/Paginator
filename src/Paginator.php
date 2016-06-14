<?php

class Paginator{
	function __invoke($selectors, $pageNum, $limit){
		$pageNum -= 1; // Zero-based
		$total = $this->getTotal($selectors);
		$lastKeyOfAll = $this->getTotal($selectors) - 1; // Zero based
		$start = $pageNum * $limit;

		if($start > $lastKeyOfAll) return [];

		$storage = $this->getStorage($start, $limit, $total);

		foreach ($selectors as $key => $selector) {
			$currentNumberOfIterms = $this->getNumberOfItemsForSelector($selector);

			if($currentNumberOfIterms > $start){
				$toBeStoredSet = $this->getItems($selector, $key, $start, $limit);
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

	public function getStorage($start, $limit, $total)
	{
		return [];
	}

	function getTotal($selectors){
		return array_sum($selectors);
	}

	function getNumberOfItemsForSelector($selector){
		return $selector;
	}

	public function getItems($selector, $key, $start, $limit)
	{
		// Not more than selector does have or limit does allow
		$set = range($start + 1, $start + min($limit, $selector - $start)); // Zero based

		// This is mostly useful to the tests
		return array_map(function($i) use($key) {
			return "$key:$i";
		}, $set);
	}

	public function addToStorage($storage, $items)
	{
		return array_merge($storage, $items);
	}
}