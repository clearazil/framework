<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;

use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel;

use Symfony\Component\EventDispatcher\EventDispatcher;

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new Acme\ContentLengthListener());
$dispatcher->addSubscriber(new Acme\GoogleListener());
$dispatcher->addSubscriber(new Acme\StringResponseListener());
$dispatcher->addSubscriber(new HttpKernel\EventListener\ResponseListener('UTF-8'));


$request = Request::createFromGlobals();
$routes = include __DIR__ . '/../src/routes.php';

$context = new RequestContext();
$matcher = new UrlMatcher($routes, $context);
$resolver = new ControllerResolver();

$requestStack = new RequestStack;
$dispatcher->addSubscriber(new HttpKernel\EventListener\RouterListener($matcher, $requestStack));

$listener = new HttpKernel\EventListener\ExceptionListener(
	'Calendar\\Controller\\ErrorController::exceptionAction');

$dispatcher->addSubscriber($listener);

$framework = new Acme\Framework($dispatcher, $resolver);
$framework = new HttpKernel\HttpCache\HttpCache($framework, new HttpKernel\HttpCache\Store(__DIR__ . '/../cache'));

$response = $framework->handle($request);
$response->send();

function render_template(Request $request) 
{
	extract($request->attributes->all(), EXTR_SKIP);
	ob_start();
	include sprintf(__DIR__ . '/../src/pages/%s.php', $_route);

	return new Response(ob_get_clean());
}