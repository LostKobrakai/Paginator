<?php

class TestPaginator extends Paginator{
	protected function getStorage($start, $limit, $total)
	{
		return [];
	}

	protected function getTotal($selectors){
		return array_sum($selectors);
	}

	protected function getNumberOfItemsForSelector($selector){
		return $selector;
	}

	protected function getItems($selector, $key, $start, $limit)
	{
		// Not more than selector does have or limit does allow
		$set = range($start + 1, $start + min($limit, $selector - $start)); // Zero based

		return array_map(function($i) use($key) {
			return "$key:$i";
		}, $set);
	}

	protected function addToStorage($storage, $items)
	{
		return array_merge($storage, $items);
	}
}