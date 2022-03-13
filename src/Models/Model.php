<?php

namespace Wordpapi\Models;

abstract class Model {
	protected array $fields;
	
	public function __construct(array $fields) {
		$this->fields = $fields;
		$this->fill();
	}
	
	/**
	 * Fills model from array of fields to properties.
	 */
	public function fill(): void {
		foreach($this->fields as $key => $value) {
			switch($key) {
				case "date":
				case "modified":
					$this->{$key} = new \DateTime($value);
					break;
				default:
					if(property_exists($this, $key)) {
						try {
							$this->{$key} = $value;
						} catch(\TypeError $e) {
						}
					}
					break;
			}
		}
	}
	
	public function getFields(): array {
		return $this->fields;
	}
}
