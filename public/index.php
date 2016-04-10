<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

use Dotenv\Dotenv;

$dotenv = new Dotenv(__DIR__ . '/..');
$dotenv->load();

$routes = include __DIR__ . '/../src/routes.php';
$sc = include __DIR__ . '/../src/container.php';
include __DIR__ . '/../src/helpers.php';

$request = Request::createFromGlobals();

$response = $sc->get('framework')->handle($request);

$response->send();

