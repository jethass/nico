<?php

namespace Nicorette\CentralBundle\Exception;

class InvalidEntityException extends \RuntimeException
{
	protected $entity;
	
	public function __construct($message, $entity = null)
	{
		parent::__construct($message);
		$this->entity = $entity;
	}
	
	/**
	* @return array|null
	*/
	public function getEntity()
	{
		return $this->entity;
	}
}