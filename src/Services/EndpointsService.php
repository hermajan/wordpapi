<?php

namespace Wordpapi\Services;

use GuzzleHttp\Client;
use Wordpapi\Endpoints\{Categories, Links, LinksCategories, Pages, Posts, Tags, Taxonomies, Types};

class EndpointsService {
	private Categories $categories;
	
	private Client $guzzle;
	
	private Links $links;
	
	private LinksCategories $linksCategories;
	
	private Pages $pages;
	
	private Posts $posts;
	
	private Tags $tags;
	
	private Taxonomies $taxonomies;
	
	private Types $types;
	
	private string $url;
	
	public function __construct(string $url, Client $guzzle) {
		$this->url = $url;
		$this->guzzle = $guzzle;
		
		$this->categories = new Categories($url, $guzzle);
		$this->links = new Links($url, $guzzle);
		$this->linksCategories = new LinksCategories($url, $guzzle);
		$this->pages = new Pages($url, $guzzle);
		$this->posts = new Posts($url, $guzzle);
		$this->tags = new Tags($url, $guzzle);
		$this->taxonomies = new Taxonomies($url, $guzzle);
		$this->types = new Types($url, $guzzle);
	}
	
	public function getCategories(): Categories {
		return $this->categories;
	}
	
	public function getGuzzle(): Client {
		return $this->guzzle;
	}
	
	public function getLinks(): Links {
		return $this->links;
	}
	
	public function getLinksCategories(): LinksCategories {
		return $this->linksCategories;
	}
	
	public function getPages(): Pages {
		return $this->pages;
	}
	
	public function getPosts(): Posts {
		return $this->posts;
	}
	
	public function getTags(): Tags {
		return $this->tags;
	}
	
	public function getTaxonomies(): Taxonomies {
		return $this->taxonomies;
	}
	
	public function getTypes(): Types {
		return $this->types;
	}
	
	public function getUrl(): string {
		return $this->url;
	}
}
