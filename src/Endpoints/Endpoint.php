<?php

namespace Wordpapi\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Nette\Utils\{Json, JsonException};
use Wordpapi\Exceptions\InvalidEndpointException;
use Wordpapi\Models\Model;

/**
 * Implementation of REST API endpoint.
 * @see https://developer.wordpress.org/rest-api/reference
 */
abstract class Endpoint {
	protected Client $guzzle;
	
	protected string $namespace = "wp/v2";
	
	protected string $route;
	
	protected string $url;
	
	public function __construct(string $url, Client $guzzle) {
		$this->url = $url;
		$this->guzzle = $guzzle;
	}
	
	/**
	 * Retrieves a collection of items.
	 */
	abstract public function list(array $arguments = []): array;
	
	/**
	 * Retrieves an item by ID.
	 */
	abstract public function retrieve(int|string $id, array $arguments = []): Model;
	
	/**
	 * Builds model for endpoint.
	 */
	abstract protected function build(array $fields, array $arguments): Model;
	
	/**
	 * Gets data from API.
	 * @throws InvalidEndpointException
	 */
	protected function get(string $route, array $arguments = []): array {
		try {
			$response = $this->guzzle->get($this->url."/wp-json/".$this->namespace."/".$route, ["query" => $arguments]);
			return (array)Json::decode($response->getBody(), Json::FORCE_ARRAY);
		} catch(GuzzleException|JsonException $e) {
			throw new InvalidEndpointException($e->getMessage(), $e->getCode(), $e);
		}
	}
}
