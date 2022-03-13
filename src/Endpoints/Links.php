<?php

namespace Wordpapi\Endpoints;

use Wordpapi\Exceptions\InvalidEndpointException;
use Wordpapi\Models\Link;

class Links extends Endpoint {
	protected string $namespace = "wordpapi";
	
	protected string $route = "links";
	
	/**
	 * @throws InvalidEndpointException
	 */
	protected function build(array $fields, array $arguments): Link {
		$categories = $this->getCategories($fields["categories"] ?? [], $arguments["with_categories"] ?? false);
		return new Link($fields, $categories);
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function list(array $arguments = []): array {
		$links = [];
		
		$items = $this->get($this->route, $arguments);
		foreach($items as $item) {
			$links[] = $this->build($item, $arguments);
		}
		
		return $links;
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function retrieve(int|string $id, array $arguments = []): Link {
		$fields = $this->get($this->route."/".$id, $arguments);
		return $this->build($fields, $arguments);
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	protected function getCategories(array $items, bool $with = false): array {
		$categories = $items;
		
		if($with === true) {
			$categoriesEndpoint = new LinksCategories($this->url, $this->guzzle);
			$categories = $categoriesEndpoint->list(["include" => $items]);
		}
		
		return $categories;
	}
}
