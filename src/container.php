<?php

use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Reference;

$sc = new DependencyInjection\ContainerBuilder();
$sc->register('context', 'Symfony\Component\Routing\RequestContext');
$sc->register('matcher', 'Symfony\Component\Routing\Matcher\UrlMatcher')
	->setArguments([$routes, new Reference('context')]);
$sc->register('request_stack', 'Symfony\Component\HttpFoundation\RequestStack');
$sc->register('resolver', 'Symfony\Component\HttpKernel\Controller\ControllerResolver');

$sc->register('listener.router', 'Symfony\Component\HttpKernel\EventListener\RouterListener')
	->setArguments([new Reference('matcher'), new Reference('request_stack')]);
$sc->register('listener.response', 'Symfony\Component\HttpKernel\EventListener\ResponseListener')
	->setArguments(['UTF-8']);
$sc->register('listener.exception', 'Symfony\Component\HttpKernel\EventListener\ExceptionListener')
	->setArguments(['Calendar\Controller\ErrorController::exceptionAction']);
$sc->register('listener.content_length', 'Acme\ContentLengthListener');
$sc->register('listener.google', 'Acme\GoogleListener');
$sc->register('listener.string_response', 'Acme\StringResponseListener');
$sc->register('dispatcher', 'Symfony\Component\EventDispatcher\EventDispatcher')
	->addMethodCall('addSubscriber', [new Reference('listener.router')])
	->addMethodCall('addSubscriber', [new Reference('listener.response')])
	->addMethodCall('addSubscriber', [new Reference('listener.exception')])
	->addMethodCall('addSubscriber', [new Reference('listener.content_length')])
	->addMethodCall('addSubscriber', [new Reference('listener.google')])
	->addMethodCall('addSubscriber', [new Reference('listener.string_response')]);

$sc->register('framework', 'Acme\Framework')
	->setArguments([new Reference('dispatcher'), new Reference('resolver')]);

return $sc;
