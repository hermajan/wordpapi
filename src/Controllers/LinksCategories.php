<?php
namespace Wordpapi\Controllers;

class LinksCategories extends \WP_REST_Controller {
	public function __construct() {
		$this->namespace = "wordpapi";
		$this->rest_base = "links/categories";
		
		$this->register_routes();
	}
	
	public function get_item($request): \WP_Error|\WP_REST_Response|\WP_HTTP_Response {
		$term = get_term((int)$request["id"]);
		if(!isset($term)) {
			return new \WP_Error("rest_link_invalid_id", __("Invalid link category ID."), ["status" => 404]);
		}
		
		return rest_ensure_response($this->prepare_item_for_response($term, $request));
	}
	
	public function get_items($request): \WP_Error|\WP_REST_Response|\WP_HTTP_Response {
		$categories = [];
		
		$termQuery = new \WP_Term_Query(["taxonomy" => "link_category", "hide_empty" => false, "include" => $request["include"] ?? []]);
		$terms = $termQuery->get_terms();
		foreach($terms as $term) {
			$response = $this->prepare_item_for_response($term, $request);
			$categories[] = $this->prepare_response_for_collection($response);
		}
		
		return rest_ensure_response($categories);
	}
	
	public function prepare_item_for_response($item, $request): \WP_Error|\WP_REST_Response|\WP_HTTP_Response {
		$data = [
			"id" => $item->term_id,
			"name" => $item->name,
			"slug" => $item->slug,
			"description" => $item->description,
			"count" => $item->count
		];
		
		$response = rest_ensure_response($data);
		if(is_wp_error($response)) {
			return $response;
		}
		
		$response->add_links($this->prepare_links($item));
		return $response;
	}
	
	public function register_routes() {
		register_rest_route($this->namespace, "/".$this->rest_base, [
			["methods" => \WP_REST_Server::READABLE, "callback" => [$this, "get_items"]]
		]);
		
		register_rest_route($this->namespace, "/".$this->rest_base."/(?P<id>[\d]+)", [
			["methods" => \WP_REST_Server::READABLE, "callback" => [$this, "get_item"]]
		]);
	}
	
	protected function prepare_links($item) {
		return [
			"self" => ["href" => rest_url($this->namespace."/".$this->rest_base."/".$item->term_id)],
			"collection" => ["href" => rest_url($this->namespace."/".$this->rest_base)]
		];
	}
}
