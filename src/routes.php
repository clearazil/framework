<?php

use Symfony\Component\Routing;
use Symfony\Component\Routing\Route;

$routes = new Routing\RouteCollection();
$routes->add('hello', new Route('/hello/{name}', ['name' => 'World']));
$routes->add('bye', new Route('/bye'));

return $routes;