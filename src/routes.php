<?php

use Symfony\Component\Routing;
use Symfony\Component\Routing\Route;

function is_leap_year($year = null) {
	if($year === null) {
		$year = date('Y');
	}

	return $year % 400 === 0 || ($year % 4 === 0 && $year % 100 !== 0);
}

$routes = new Routing\RouteCollection();
$routes->add('hello', new Route('/hello/{name}', ['name' => 'World', '_controller' => 'render_template']));
$routes->add('bye', new Route('/bye', ['_controller' => 'render_template']));
$routes->add('leap_year', new Route('/is_leap_year/{year}', [
	'year' => null,
	'_controller' => 'Controllers\LeapYearController::indexAction'
]));

return $routes;