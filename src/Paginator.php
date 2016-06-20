<?php

abstract class Paginator{
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

	abstract protected function getStorage($start, $limit, $total);

	abstract protected function getTotal($selectors);

	abstract protected function getNumberOfItemsForSelector($selector);

	abstract protected function getItems($selector, $key, $start, $limit, $storage);

	abstract protected function addToStorage($storage, $items);
}