<?php

use Symfony\Component\Routing;
use Symfony\Component\Routing\Route;

$routes = new Routing\RouteCollection();
$routes->add('hello', new Route('/hello/{name}', ['name' => 'World', '_controller' => 'render_template']));
$routes->add('bye', new Route('/bye', ['_controller' => 'render_template']));
$routes->add('leap_year', new Route('/is_leap_year/{year}', [
	'year' => null,
	'_controller' => 'Calendar\Controller\LeapYearController::indexAction'
]));

return $routes;