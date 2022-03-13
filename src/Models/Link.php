<?php

namespace Wordpapi\Models;

use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\Strings;

/**
 * Link
 *
 * @ORM\Table(name="wp_links", indexes={@ORM\Index(name="link_visible", columns={"link_visible"})})
 * @ORM\Entity
 */
class Link {
	/**
	 * @ORM\Column(name="link_id", type="bigint", nullable=false, options={"unsigned"=true})
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private int $id;
	
	/**
	 * @ORM\Column(name="link_url", type="string", length=255, nullable=false)
	 */
	private string $url = "";
	
	/**
	 * @ORM\Column(name="link_name", type="string", length=255, nullable=false)
	 */
	private string $name = "";
	
	/**
	 * @ORM\Column(name="link_image", type="string", length=255, nullable=false)
	 */
	private string $image = "";
	
	/**
	 * @ORM\Column(name="link_target", type="string", length=25, nullable=false)
	 */
	private string $target = "";
	
	/**
	 * @ORM\Column(name="link_description", type="string", length=255, nullable=false)
	 */
	private string $description = "";
	
	/**
	 * @ORM\Column(name="link_visible", type="string", length=20, nullable=false, options={"default"="Y"})
	 */
	private string $visible = "Y";
	
	/**
	 * @ORM\Column(name="link_owner", type="bigint", nullable=false, options={"default"=1, "unsigned"=true})
	 */
	private int $owner = 1;
	
	/**
	 * @ORM\Column(name="link_rating", type="integer", nullable=false)
	 */
	private int $rating = 0;
	
	/**
	 * @ORM\Column(name="link_updated", type="datetime", nullable=false)
	 */
	private \DateTime $updated;
	
	/**
	 * @ORM\Column(name="link_rel", type="string", length=255, nullable=false)
	 */
	private string $rel = "";
	
	/**
	 * @ORM\Column(name="link_notes", type="text", length=16777215, nullable=false)
	 */
	private string $notes;
	
	/**
	 * @ORM\Column(name="link_rss", type="string", length=255, nullable=false)
	 */
	private string $rss = "";
	
	public function __construct() {
		$this->updated = new \DateTime("0000-00-00 00:00:00");
	}
	
	public function getId(): int {
		return $this->id;
	}
	
	public function setId(int $id): Link {
		$this->id = $id;
		return $this;
	}
	
	public function getUrl(): string {
		return $this->url;
	}
	
	public function setUrl(string $url): Link {
		$this->url = $url;
		return $this;
	}
	
	public function getName(): string {
		return $this->name;
	}
	
	public function setName(string $name): Link {
		$this->name = $name;
		return $this;
	}
	
	public function getImage(): string {
		return $this->image;
	}
	
	public function setImage(string $image): Link {
		$this->image = $image;
		return $this;
	}
	
	public function getTarget(): string {
		return $this->target;
	}
	
	public function setTarget(string $target): Link {
		$this->target = $target;
		return $this;
	}
	
	public function getDescription(): string {
		return $this->description;
	}
	
	public function setDescription(string $description): Link {
		$this->description = $description;
		return $this;
	}
	
	public function getVisible(): string {
		return $this->visible;
	}
	
	public function setVisible(string $visible): Link {
		$this->visible = $visible;
		return $this;
	}
	
	public function getOwner(): int {
		return $this->owner;
	}
	
	public function setOwner(int $owner): Link {
		$this->owner = $owner;
		return $this;
	}
	
	public function getRating(): int {
		return $this->rating;
	}
	
	public function setRating(int $rating): Link {
		$this->rating = $rating;
		return $this;
	}
	
	public function getUpdated(): \DateTime {
		return $this->updated;
	}
	
	public function setUpdated(\DateTime $updated): Link {
		$this->updated = $updated;
		return $this;
	}
	
	public function getRel(): string {
		return $this->rel;
	}
	
	public function setRel(string $rel): Link {
		$this->rel = $rel;
		return $this;
	}
	
	public function getNotes(): string {
		return $this->notes;
	}
	
	public function setNotes(string $notes): Link {
		$this->notes = $notes;
		return $this;
	}
	
	public function getRss(): string {
		return $this->rss;
	}
	
	public function setRss(string $rss): Link {
		$this->rss = $rss;
		return $this;
	}
	
	public function createFromColumns(array $data):void {
		foreach($data as $key => $value) {
			$function = "set".Strings::firstUpper(str_replace("link_", "", $key));
			if(method_exists($this, $function)) {
				switch($function) {
					case "setUpdated":
						$value = new \DateTime($value);
						break;
				}
				$this->{$function}($value);
			}
		}
	}
}
