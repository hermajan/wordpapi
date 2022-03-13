<?php

namespace Wordpapi\Endpoints;

use Wordpapi\Exceptions\InvalidEndpointException;
use Wordpapi\Models\Tag;

class Tags extends Endpoint {
	protected string $route = "tags";
	
	protected function build(array $fields, array $arguments): Tag {
		return new Tag($fields);
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function list(array $arguments = []): array {
		$tags = [];
		
		$items = $this->get($this->route, $arguments);
		foreach($items as $item) {
			$tags[] = $this->build($item, $arguments);
		}
		
		return $tags;
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function retrieve(int|string $id, array $arguments = []): Tag {
		$fields = $this->get($this->route."/".$id, $arguments);
		return $this->build($fields, $arguments);
	}
}
