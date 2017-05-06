<?php

namespace App\Middleware;

class Middleware
{
	protected $container;
	public function __construct($contain)
	{
		$this->container = $contain;
	}
}

