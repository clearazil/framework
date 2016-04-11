<?php

namespace Acme\Core;

use Acme\Core\View;

class Controller {
	public function __construct()
	{
		$this->view = new View;
	}

}