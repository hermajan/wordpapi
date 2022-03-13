<?php
namespace Wordpapi\Models\Fields;

trait Id {
	protected int $id;
	
	public function getId(): int {
		return $this->id;
	}
}
