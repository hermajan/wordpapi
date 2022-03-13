<?php

namespace Wordpapi\Models\Fields;

trait Description {
	protected string $description;
	
	protected string $name;
	
	public function getDescription(): string {
		return $this->description;
	}
	
	public function getName(): string {
		return $this->name;
	}
}
