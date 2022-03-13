<?php

namespace Wordpapi\Models;

use Wordpapi\Models\Fields\{Description, Slug};

class Type extends Model {
	use Description, Slug;
	
	protected array $taxonomies = [];
	
	public function __construct(array $fields, array $taxonomies = []) {
		parent::__construct($fields);
		$this->taxonomies = $taxonomies;
	}
}
