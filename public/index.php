<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;

$request = Request::createFromGlobals();

$routes = include __DIR__ . '/../src/routes.php';

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

try {
	$request->attributes->add($matcher->match($request->getPathInfo()));
	$response = call_user_func($request->attributes->get('_controller', 'render_template'), $request);
} catch (ResourceNotFoundException $e) {
	$response = new Response('Not Found', 404);
} catch (Exception $e) {
	$response = new Response('An error occured', 500);
}

$response->send();

function render_template($request) 
{
	extract($request->attributes->all(), EXTR_SKIP);
	ob_start();
	include sprintf(__DIR__ . '/../src/pages/%s.php', $_route);

	return new Response(ob_get_clean());
}