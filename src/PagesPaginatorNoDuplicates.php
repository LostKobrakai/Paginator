<?php

class PagesPaginatorNoDuplicates extends PagesPaginator{
	protected function getItems($selector, $key, $start, $limit, $storage)
	{
		return wire('pages')->find($selector . ", start=$start, limit=$limit, id!=$storage");
	}
}