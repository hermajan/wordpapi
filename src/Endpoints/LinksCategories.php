<?php

namespace Wordpapi\Endpoints;

use Wordpapi\Exceptions\InvalidEndpointException;
use Wordpapi\Models\LinkCategory;

class LinksCategories extends Endpoint {
	protected string $namespace = "wordpapi";
	
	protected string $route = "links/categories";
	
	protected function build(array $fields, array $arguments): LinkCategory {
		return new LinkCategory($fields);
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
	public function retrieve(int|string $id, array $arguments = []): LinkCategory {
		$fields = $this->get($this->route."/".$id, $arguments);
		return $this->build($fields, $arguments);
	}
}
