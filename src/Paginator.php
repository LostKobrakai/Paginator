<?php

class Paginator{
	function __invoke($selectors, $pageNum, $limit){
		$pageNum -= 1; // Zero-based
		$lastKeyOfAll = $this->getLastKey($selectors); // Zero based
		$start = $pageNum * $limit;

		if($start > $lastKeyOfAll) return [];

		$storage = [];

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

	function getLastKey($selectors){
		return array_sum($selectors) - 1;
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