<?php
namespace Wordpapi\Controllers;

class Links extends \WP_REST_Controller {
	public function __construct() {
		$this->namespace = "wordpapi";
		$this->rest_base = "links";
		
		$this->register_routes();
	}
	
	public function get_item($request): \WP_Error|\WP_REST_Response|\WP_HTTP_Response {
		$bookmark = get_bookmark($request["id"]);
		if(!isset($bookmark) or $bookmark->link_visible !== "Y") {
			return new \WP_Error("rest_link_invalid_id", __("Invalid link ID."), ["status" => 404]);
		}
		
		return rest_ensure_response($this->prepare_item_for_response($bookmark, $request));
	}
	
	public function get_items($request): \WP_Error|\WP_REST_Response|\WP_HTTP_Response {
		$links = [];
		
		$bookmarks = get_bookmarks(["hide_invisible" => true]);
		foreach($bookmarks as $link) {
			$response = $this->prepare_item_for_response($link, $request);
			$links[] = $this->prepare_response_for_collection($response);
		}
		
		return rest_ensure_response($links);
	}
	
	public function prepare_item_for_response($item, $request): \WP_Error|\WP_REST_Response|\WP_HTTP_Response {
		$data = [
			"id" => $item->link_id,
			"url" => $item->link_url,
			"name" => $item->link_name,
			"image" => $item->link_image,
			"target" => $item->link_target,
			"description" => $item->link_description,
			"visible" => $item->link_visible,
			"author" => $item->link_owner,
			"rating" => $item->link_rating,
			"modified" => mysql_to_rfc3339($item->link_updated),
			"rel" => $item->link_rel,
			"notes" => $item->link_notes,
			"rss" => $item->link_rss,
			"categories" => wp_get_object_terms($item->link_id, "link_category", ["fields" => "ids"]),
		];
		
		$response = rest_ensure_response($data);
		if(is_wp_error($response)) {
			return $response;
		}
		
		$response->add_links($this->prepare_links($item));
		return $response;
	}
	
	public function register_routes(): void {
		register_rest_route($this->namespace, "/".$this->rest_base, [
			["methods" => \WP_REST_Server::READABLE, "callback" => [$this, "get_items"]]
		]);
		
		register_rest_route($this->namespace, "/".$this->rest_base."/(?P<id>[\d]+)", [
			["methods" => \WP_REST_Server::READABLE, "callback" => [$this, "get_item"]]
		]);
	}
	
	protected function prepare_links($item): array {
		return [
			"self" => ["href" => rest_url($this->namespace."/".$this->rest_base."/".$item->link_id)],
			"collection" => ["href" => rest_url($this->namespace."/".$this->rest_base)],
			"author" => ["href" => rest_url("/wp/v2/users/".$item->link_owner)]
		];
	}
}
