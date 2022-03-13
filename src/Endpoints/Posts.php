<?php
namespace Wordpapi\Endpoints;

use Wordpapi\Exceptions\InvalidEndpointException;
use Wordpapi\Models\Post;

/**
 * Posts endpoint
 * @see https://developer.wordpress.org/rest-api/reference/posts
 */
class Posts extends Endpoint {
	protected string $route = "posts";
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function retrieveBySlug(string $slug, array $arguments = []): ?Post {
		$posts = $this->get($this->route, ["slug" => $slug] + $arguments);
		if(empty($posts)) {
			return null;
		}
		return $this->build($posts[0], $arguments);
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	protected function build(array $fields, array $arguments): Post {
		$categories = $this->getCategories($fields["categories"] ?? [], $arguments["with_categories"] ?? false);
		$tags = $this->getTags($fields["tags"] ?? [], $arguments["with_tags"] ?? false);
		return new Post($fields, $categories, $tags);
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function list(array $arguments = []): array {
		$posts = [];
		
		$items = $this->get($this->route, $arguments);
		foreach($items as $item) {
			$posts[] = $this->build($item, $arguments);
		}
		
		return $posts;
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	public function retrieve(int|string $id, array $arguments = []): Post {
		$fields = $this->get($this->route."/".$id, $arguments);
		return $this->build($fields, $arguments);
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	protected function getCategories(array $items, bool $with = false): array {
		$categories = $items;
		
		if($with === true) {
			$categoriesEndpoint = new Categories($this->url, $this->guzzle);
			$categories = $categoriesEndpoint->list(["include" => $items]);
		}
		
		return $categories;
	}
	
	/**
	 * @throws InvalidEndpointException
	 */
	protected function getTags(array $items, bool $with = false): array {
		$tags = $items;
		
		if($with === true) {
			$tagsEndpoint = new Tags($this->url, $this->guzzle);
			$tags = $tagsEndpoint->list(["include" => $items]);
		}
		
		return $tags;
	}
}
