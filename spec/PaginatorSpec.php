<?php 

/**
 * Set's consist of 
 * nums: key determines the selector number and value the number of items the selector does have
 * pageNum: the current page one is on
 * limit: the max number of items on a page
 * result: the set resulting from the pagination "$numKey:$item"
 */
describe('Paginator', function(){
	before(function(){
		$this->paginator = new Paginator();
	});

	it('should return an empty set for a start value greater the total of input data', function(){
		$sets = array();

		$sets[] = array(
			'nums' => [
				1 => 1, 
				2 => 1
			],
			'pageNum' => 2,
			'limit' => 2,
			'result' => []
		);
		
		$sets[] = array(
			'nums' => [
				1 => 2, 
			],
			'pageNum' => 2,
			'limit' => 2,
			'result' => []
		);

		foreach ($sets as $set) {
			//expect(count($this->paginator($set['nums'], $set['pageNum'], $set['limit'])))->toBeLessThan($set['limit']);
			expect($this->paginator($set['nums'], $set['pageNum'], $set['limit']))->toBe($set['result']);
		}
	});

	it('should return only a single selectors set if enough found', function(){
		$sets = array();

		$sets[] = array(
			'nums' => [
				1 => 3, 
				2 => 1
			],
			'pageNum' => 1,
			'limit' => 3,
			'result' => ['1:1', '1:2', '1:3']
		);
		
		$sets[] = array(
			'nums' => [
				1 => 2, 
			],
			'pageNum' => 1,
			'limit' => 2,
			'result' => ['1:1', '1:2']
		);
		
		$sets[] = array(
			'nums' => [
				1 => 1, 
			],
			'pageNum' => 1,
			'limit' => 2,
			'result' => ['1:1']
		);

		
		foreach ($sets as $set) {
			$result = $this->paginator($set['nums'], $set['pageNum'], $set['limit']);
			expect($result)->toBe($set['result']);
			expect(count($result))->toBeLessThan($set['limit'] + 1);
		}
	});

	it('should return from multiple selectors if needed', function(){
		$sets = array();

		$sets[] = array(
			'nums' => [
				1 => 4, 
				2 => 4
			],
			'pageNum' => 2,
			'limit' => 3,
			'result' => ['1:4', '2:1', '2:2']
		);

		$sets[] = array(
			'nums' => [
				1 => 7, 
				2 => 4,
				3 => 4
			],
			'pageNum' => 2,
			'limit' => 6,
			'result' => ['1:7', '2:1', '2:2', '2:3', '2:4', '3:1']
		);

		foreach ($sets as $set) {
			$result = $this->paginator($set['nums'], $set['pageNum'], $set['limit']);
			expect($result)->toBe($set['result']);
			expect(count($result))->toBeLessThan($set['limit'] + 1);
		}
	});

	it('should return less than limit if total is to small', function(){
		$sets = array();

		$sets[] = array(
			'nums' => [
				1 => 2, 
				2 => 2
			],
			'pageNum' => 1,
			'limit' => 6,
			'result' => ['1:1', '1:2', '2:1', '2:2']
		);

		$sets[] = array(
			'nums' => [
				1 => 7, 
				2 => 3,
				3 => 1
			],
			'pageNum' => 2,
			'limit' => 6,
			'result' => ['1:7', '2:1', '2:2', '2:3', '3:1']
		);

		foreach ($sets as $set) {
			$result = $this->paginator($set['nums'], $set['pageNum'], $set['limit']);
			expect($result)->toBe($set['result']);
			expect(count($result))->toBeLessThan($set['limit'] + 1);
		}
	});

});