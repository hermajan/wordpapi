<?php

namespace Wordpapi\Endpoints;

use Wordpapi\Exceptions\InvalidEndpointException;
use Wordpapi\Models\Taxonomy;

/**
 * Taxonomies endpoint
 * @see https://developer.wordpress.org/rest-api/reference/taxonomies
 */
class Taxonomies extends Endpoint {
	protected string $route = "taxonomies";
	
	/**
	 * @throws InvalidEndpointException
	 */
	protected function build(array $fields, array $arguments): Taxonomy {
		$types = $this->getTypes($fields["types"] ?? [], $arguments["with_types"] ?? false);
		return new Taxonomy($fields, $types);
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function list(array $arguments = []): array {
		$taxonomies = [];
		
		$items = $this->get($this->route, $arguments);
		foreach($items as $item) {
			$taxonomies[] = $this->build($item, $arguments);
		}
		
		return $taxonomies;
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function retrieve(int|string $id, array $arguments = []): Taxonomy {
		$taxonomy = $this->get($this->route."/".$id, $arguments);
		return $this->build($taxonomy, $arguments);
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	protected function getTypes(array $items, bool $with = false): array {
		$types = $items;
		
		if($with === true) {
			$types = [];
			$typesEndpoint = new Types($this->url, $this->guzzle);
			foreach($items as $item) {
				$types[] = $typesEndpoint->retrieve($item);
			}
		}
		
		return $types;
	}
}
