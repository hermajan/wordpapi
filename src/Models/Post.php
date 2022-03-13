<?php

namespace Wordpapi\Models;

use Wordpapi\Models\Fields\{Date, Id, Slug};

class Post extends Model {
	use Date, Id, Slug;
	
	protected array $categories;
	
	protected string $content;
	
	protected string $excerpt;
	
	protected string $status;
	
	protected array $tags;
	
	protected string $title;
	
	protected bool $visible;
	
	public function __construct(array $fields, array $categories = [], array $tags = []) {
		parent::__construct($fields);
		$this->categories = $categories;
		$this->tags = $tags;
	}
	
	public function fill(): void {
		parent::fill();
		
		foreach($this->fields as $key => $value) {
			switch($key) {
				case "title":
				case "excerpt":
				case "content":
					$this->{$key} = $value["rendered"];
					break;
				case "status":
					$this->{$key} = $value;
					if($value == "publish") {
						$this->visible = true;
					} else {
						$this->visible = false;
					}
					break;
			}
		}
	}
	
	public function getCategories(): array {
		return $this->categories;
	}
	
	public function getContent(): string {
		return $this->content;
	}
	
	public function getExcerpt(): string {
		return $this->excerpt;
	}
	
	public function getStatus(): string {
		return $this->status;
	}
	
	public function getTags(): array {
		return $this->tags;
	}
	
	public function getTitle(): string {
		return $this->title;
	}
	
	public function isVisible(): bool {
		return $this->visible;
	}
}
