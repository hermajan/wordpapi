<?php
namespace Wordpapi\Endpoints;

use Wordpapi\Exceptions\InvalidEndpointException;
use Wordpapi\Models\Type;

/**
 * Types endpoint
 * @see https://developer.wordpress.org/rest-api/reference/types
 */
class Types extends Endpoint {
	protected string $route = "types";
	
	/**
	 * @throws InvalidEndpointException
	 */
	protected function build(array $fields, array $arguments): Type {
		$taxonomies = $this->getTaxonomies($fields["taxonomies"] ?? [], $arguments["with_taxonomies"] ?? false);
		return new Type($fields, $taxonomies);
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function list(array $arguments = []): array {
		$types = [];
		
		$items = $this->get($this->route, $arguments);
		foreach($items as $item) {
			$types[] = $this->build($item, $arguments);
		}
		
		return $types;
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function retrieve(int|string $id, array $arguments = []): Type {
		$fields = $this->get($this->route."/".$id, $arguments);
		return $this->build($fields, $arguments);
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	protected function getTaxonomies(array $items, bool $with = false): array {
		$taxonomies = $items;
		
		if($with === true) {
			$taxonomies = [];
			$taxonomiesEndpoint = new Taxonomies($this->url, $this->guzzle);
			foreach($items as $item) {
				$taxonomies[] = $taxonomiesEndpoint->retrieve($item);
			}
		}
		
		return $taxonomies;
	}
}
