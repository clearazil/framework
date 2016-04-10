<?php

function render_template(\Symfony\Component\HttpFoundation\Request $request) 
{
	extract($request->attributes->all(), EXTR_SKIP);
	ob_start();
	include sprintf(__DIR__ . '/../src/pages/%s.php', $_route);

	return new \Symfony\Component\HttpFoundation\Response(ob_get_clean());
}

function config($setting)
{
	$config = include __DIR__ . '/../src/config.php';
	
	return $config[$setting];
}