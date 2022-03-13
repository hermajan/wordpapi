<?php

namespace Wordpapi\Models;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception as DbalException;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\ForwardCompatibility\Result;

class Links {
	private Connection $connection;
	
	public function __construct(Connection $connection) {
		$this->connection = $connection;
	}
	
	/**
	 * @throws DbalException
	 * @throws Exception
	 */
	public function getLinks(array $categories = []): array {
		$qb = $this->connection->createQueryBuilder()
			->select("wl.*")->from("wp_term_taxonomy", "wtt")
			->join("wtt", "wp_terms", "wt", "wtt.term_id = wt.term_id")
			->join("wtt", "wp_term_relationships", "wtr", "wtt.term_taxonomy_id = wtr.term_taxonomy_id")
			->join("wtt", "wp_links", "wl", "wl.link_id = wtr.object_id")
			->where("wtt.taxonomy = 'link_category'");
		
		if(!empty($categories)) {
			$qb->andWhere("wt.slug in (:categories)")->setParameter("categories", $categories, Connection::PARAM_STR_ARRAY);
		}
		
		/** @var Result $result */
		$result = $qb->orderBy("wl.link_name")->execute();
		return $result->fetchAllAssociative();
	}
}
