<?php
namespace Wordpapi\Endpoints;

use Wordpapi\Exceptions\InvalidEndpointException;
use Wordpapi\Models\Page;

/**
 * Pages endpoint
 * @see https://developer.wordpress.org/rest-api/reference/pages
 */
class Pages extends Posts {
	protected string $route = "pages";
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function list(array $arguments = []): array {
		$pages = [];
		
		$items = $this->get($this->route, $arguments);
		foreach($items as $item) {
			$pages[] = $this->build($item, $arguments);
		}
		
		return $pages;
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function retrieve(int|string $id, array $arguments = []): Page {
		$fields = $this->get($this->route."/".$id, $arguments);
		return $this->build($fields, $arguments);
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function retrieveBySlug(string $slug, array $arguments = []): ?Page {
		$pages = $this->get($this->route, ["slug" => $slug] + $arguments);
		if(empty($pages)) {
			return null;
		}
		return $this->build($pages[0], $arguments);
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	protected function build(array $fields, array $arguments): Page {
		$categories = $this->getCategories($fields["categories"] ?? [], $arguments["with_categories"] ?? false);
		$tags = $this->getTags($fields["tags"] ?? [], $arguments["with_tags"] ?? false);
		return new Page($fields, $categories, $tags);
	}
}
