<?php

namespace Wordpapi\Endpoints;

use Wordpapi\Exceptions\InvalidEndpointException;
use Wordpapi\Models\Category;

/**
 * Categories endpoint
 * @see https://developer.wordpress.org/rest-api/reference/categories
 */
class Categories extends Endpoint {
	protected string $route = "categories";
	
	protected function build(array $fields, array $arguments): Category {
		return new Category($fields);
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function list(array $arguments = []): array {
		$categories = [];
		
		$items = $this->get($this->route, $arguments);
		foreach($items as $item) {
			$categories[] = $this->build($item, $arguments);
		}
		
		return $categories;
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function retrieve(int|string $id, array $arguments = []): Category {
		$fields = $this->get($this->route."/".$id, $arguments);
		return $this->build($fields, $arguments);
	}
}
