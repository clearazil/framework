<?php
namespace Acme;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\HttpKernel;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Acme\ResponseEvent;

class Framework extends HttpKernel
{

}