<?php

use Symfony\Component\Routing;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

function is_leap_year($year = null) {
	if($year === null) {
		$year = date('Y');
	}

	return $year % 400 === 0 || ($year % 4 === 0 && $year % 100 !== 0);
}

$routes = new Routing\RouteCollection();
$routes->add('hello', new Route('/hello/{name}', ['name' => 'World', '_controller' => 'render_template']));
$routes->add('bye', new Route('/bye'));
$routes->add('leap_year', new Route('/is_leap_year/{year}', [
	'year' => null,
	'_controller' => function($request) {
		if(is_leap_year($request->attributes->get('year'))) {
			return new Response('Yep, this is a leap year!');
		}

		return new Response('Nope, this is not a leap year.');
	}
]));

return $routes;