<?php 

describe('Paginator', function(){
	before(function(){
		$this->paginator = new PagesPaginator();
	});

	it('should be instantiatable', function(){
		$instantiation = function(){
			new PagesPaginator();
		};
		expect($instantiation)->not->toThrow();
	});

});