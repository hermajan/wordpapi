<?php
namespace Wordpapi\Models\Fields;

trait Date {
	protected \DateTime $date;
	
	protected \DateTime $modified;
	
	public function getDate(): \DateTime {
		return $this->date;
	}
	
	public function getModified(): \DateTime {
		return $this->modified;
	}
}
