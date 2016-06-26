<?php 

describe('PagesPaginatorNoDuplicates', function(){
	before(function(){
		$this->paginator = new PagesPaginatorNoDuplicates();
	});

	it('should be instantiatable', function(){
		$instantiation = function(){
			new PagesPaginatorNoDuplicates();
		};
		expect($instantiation)->not->toThrow();
	});

});