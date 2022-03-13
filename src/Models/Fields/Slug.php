<?php

namespace Wordpapi\Models\Fields;

trait Slug {
	protected string $slug;
	
	public function getSlug(): string {
		return $this->slug;
	}
}
