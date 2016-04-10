<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$routes = include __DIR__ . '/../src/routes.php';
$sc = include __DIR__ . '/../src/container.php';

$request = Request::createFromGlobals();

$response = $sc->get('framework')->handle($request);

$response->send();

function render_template(Request $request) 
{
	extract($request->attributes->all(), EXTR_SKIP);
	ob_start();
	include sprintf(__DIR__ . '/../src/pages/%s.php', $_route);

	return new Response(ob_get_clean());
}