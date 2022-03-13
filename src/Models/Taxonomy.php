<?php

namespace Wordpapi\Models;

use Wordpapi\Models\Fields\{Description, Slug};

class Taxonomy extends Model {
	use Description, Slug;
	
	protected array $types;
	
	public function __construct(array $fields, array $types = []) {
		parent::__construct($fields);
		$this->types = $types;
	}
}
