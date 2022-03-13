<?php

namespace Wordpapi\Models;

class Page extends Post {
	protected int $order;
	
	public function fill(): void {
		parent::fill();
		
		foreach($this->fields as $key => $value) {
			switch($key) {
				case "menu_order":
					$this->order = $value;
					break;
			}
		}
	}
	
	public function getOrder(): int {
		return $this->order;
	}
}
