<?php

namespace Wordpapi\Models;

class Category extends Taxonomy {
	protected int $count;
	
	public function getCount(): int {
		return $this->count;
	}
}
