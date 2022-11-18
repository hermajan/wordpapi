<?php
namespace Wordpapi\DI;

use Nette\DI\CompilerExtension;
use Nette\Schema\{Expect, Schema};
use Wordpapi\Services\EndpointsService;

class WordpapiExtension extends CompilerExtension {
	public function getConfigSchema(): Schema {
		return Expect::structure([
			"url" => Expect::string()->required()
		]);
	}
	
	public function loadConfiguration(): void {
		$config = (array)$this->getConfig();
		$builder = $this->getContainerBuilder();
		
		$builder->addDefinition($this->prefix("endpoints"))
			->setFactory(EndpointsService::class, [$config["url"]]);
	}
}
