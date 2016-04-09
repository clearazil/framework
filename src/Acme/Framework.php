<?php
namespace Acme;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Acme\ResponseEvent;

class Framework implements HttpKernelInterface
{
	private $matcher;
	private $resolver;
	private $dispatcher;

	public function __construct(EventDispatcher $dispatcher, UrlMatcherInterface $matcher, ControllerResolverInterface $resolver)
	{
		$this->matcher = $matcher;
		$this->resolver = $resolver;
		$this->dispatcher = $dispatcher;
	}

	public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
	{
		$this->matcher->getContext()->fromRequest($request);

		try {
			$request->attributes->add($this->matcher->match($request->getPathInfo()));

			$controller = $this->resolver->getController($request);
			$arguments = $this->resolver->getArguments($request, $controller);

			$response = call_user_func_array($controller, $arguments);
		} catch(ResourceNotFoundException $e) {
			$response = new Response('Not Found', 404);
		} catch(\Exception $e) {
			$response = new Response('An error occured', 500);
		}

		$this->dispatcher->dispatch('response', new responseEvent($response, $request));

		return $response;
	}
}