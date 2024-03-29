<?php

namespace Wordpapi\Models;

use Wordpapi\Models\Fields\{Date, Description, Id};

class Link extends Model {
	use Id, Date, Description;
	
	protected array $categories;
	
	protected string $image;
	
	protected string $target;
	
	protected string $url;
	
	protected bool $visible;
	
	public function __construct(array $fields, array $categories = []) {
		parent::__construct($fields);
		$this->categories = $categories;
	}
	
	public function fill(): void {
		parent::fill();
		
		foreach($this->fields as $key => $value) {
			switch($key) {
				case "visible":
					if($value == "Y") {
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
	
	public function getImage(): string {
		return $this->image;
	}
	
	public function getTarget(): string {
		return $this->target;
	}
	
	public function getUrl(): string {
		return $this->url;
	}
	
	public function isVisible(): bool {
		return $this->visible;
	}
}
